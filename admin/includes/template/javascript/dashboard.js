/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  "use strict";
  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "ui-sortable-placeholder",
    forceHelperSize: true,
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    start: function(e, ui) {
      ui.placeholder.height(ui.helper[0].scrollHeight);
    },
    update : function(event, ui) {
      if (this === ui.item.parent()[0]) {
        var itemStr = getItems('.connectedSortable');
        zcJS.ajax({
          url: "zcAjaxHandler.php?act=dashboardWidget&method=updateWidgetPositions",
          data: {'items': itemStr}
        }).done(function( msg ) {
        });
      }
    }
  });


  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  $('.widget-add').click(function (e) {
    zcJS.ajax({
      url: "zcAjaxHandler.php?act=dashboardWidget&method=getInstallableWidgets",
      data: {}
    }).done(function( response ) {
      $('.add-widget-container').html(response.html);
      $('#add-widget').modal('show');
    });


  });



});

function getItems(container)
{
  var columns = [];
  $(container).each(function(){
    columns.push($(this).sortable('toArray').join(','));
  });
  return columns.join('|');
}

function doWidgetEdit(id)
{
  //$(".columns").sortable('disable');
  zcJS.ajax({
    url: "zcAjaxHandler.php?act=dashboardWidget&method=getWidgetEdit",
    data: {'id': id}
  }).done(function( response ) {
    if (response.html)
    {
      $('#'+ id).find('.widget-body').html(response.html);
      createSortables();
    }
  });
}
