<?php
/**
 * @package classes
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: New in v1.6.0 $
 */
namespace ZenCart\ListingBox\boxes;

/**
 * Class LeadMusicGenre
 * @package ZenCart\ListingBox\boxes
 */
class LeadMediaManagerClips extends AbstractLeadListingBox
{

    /**
     *
     */
    public function initQueryAndLayout()
    {


        $this->listingQuery = array(
            'mainTable' => array(
                'table' => TABLE_MEDIA_CLIPS,
                'alias' => 'mtp',
                'fkeyFieldLeft' => 'clip_id',
            ),
            'whereClauses' => array(
                array(
                    'type' => 'AND',
                    'table' => TABLE_MEDIA_CLIPS,
                    'field' => 'media_id',
                    'value' => ':media_id:'
                )
            ),
            'bindVars' => array(
                array(
                    ':media_id:',
                    $this->request->readGet('media_id'),
                    'integer'
                )
            ),
            'isPaginated' => true,
            'pagination' => array(
                'scrollerParams' => array(
                    'navLinkText' => TABLE_HEADING_MEDIA_CLIP_NAME,
                    'pagingVarSrc' => 'post'
                )
            ),
        );

        $this->outputLayout = array(
            'pageTitle' => $this->getTitle(),
//            'deleteItemHandlerTemplate' => 'tplItemRowDeleteHandlerMusicGenre.php',
            'allowDelete' => true,
//            'extraDeleteParameters' => '&product_id=' . $this->request->readGet('product_id'),
            'allowEdit' => false,
            'relatedLinks' => array(
                array(
                    'text' => BOX_CATALOG_RECORD_ARTISTS,
                    'href' => zen_href_link(FILENAME_RECORD_ARTISTS)
                ),
                array(
                    'text' => BOX_CATALOG_RECORD_COMPANY,
                    'href' => zen_href_link(FILENAME_RECORD_COMPANY)
                ),
                array(
                    'text' => BOX_CATALOG_MUSIC_GENRE,
                    'href' => zen_href_link(FILENAME_MUSIC_GENRE)
                ),
                array(
                    'text' => BOX_CATALOG_MEDIA_TYPES,
                    'href' => zen_href_link(FILENAME_MEDIA_TYPES)
                )
            ),
            'actionLinksList' => array(
                'listView' => array(
                    'linkGetAllGetParams' => true,
                    'linkGetAllGetParamsIgnore' => array(
                        'action',
                        'clip_id'
                    )
                ),
                'addView' => array(
                    'linkGetAllGetParams' => true,
                    'linkGetAllGetParamsIgnore' => array(
                        'action',
                        'clip_id'
                    )
                ),
                'parentView' => array(
                    'linkTitle' => 'Parent Collection',
                    'linkCmd' => FILENAME_MEDIA_MANAGER,
                    'linkGetAllGetParams' => true,
                    'linkGetAllGetParamsIgnore' => array(
                        'action',
                        'clip_id'
                    )
                )
            ),
            'listMap' => array(
                'clip_filename',
            ),
            'editMap' => array(
//                'media_name',
            ),
            'fields' => array(
                'clip_filename' => array(
                    'bindVarsType' => 'string',
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_MEDIA_CLIP_NAME,
                            'size' => '30'
                        )
                    )
                ),
                'media_id' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_MEDIA,
                            'size' => '30'
                        )
                    )
                ),
                'clip_id' => array(
                    'bindVarsType' => 'integer',
                ),
            ),
            'extraRowActions' => array(),
        );
    }

    protected function getTitle()
    {
        $sql = "SELECT media_name FROM " . TABLE_MEDIA_MANAGER . " WHERE media_id = :id:";
        $sql = $this->dbConn->bindvars($sql, ':id:', $this->request->readGet('media_id'), 'integer');
        $result = $this->dbConn->execute($sql);
        return $result->fields['media_name'];
    }

}
