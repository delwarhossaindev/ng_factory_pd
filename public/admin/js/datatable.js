const generate_datatable = (route,columns,order,button,buttonText,db_table, filter = {}, func = null) => {
  var data = [];
  var action = [
    {data: 'action', name: 'action', orderable: false, searchable: false}
  ];
  columns.forEach(element => {
      data.push({
          data: element.indexOf('.') > -1 ? element.split('.')[0] : element,
          name: element
      });
  });

  filter ? $('.data-table').DataTable().destroy() : '';
  button ? Array.prototype.push.apply(data,action) : data;
  
  let table = $('.data-table').DataTable({
      "processing": true,
      "serverSide": true,
      "paginate": true,
      "responsive": {
        details: {
            display: $.fn.dataTable.Responsive.display.modal({}),
            renderer: $.fn.dataTable.Responsive.renderer.tableAll()
        }
      },
      "order": [ [1, order] ],
      "language": 
      {          
      "processing": '<div class="sk-wave sk-primary"><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div></div>',
      },
      "ajax":{
        "url": route,
        "dataType": "json",
        "type": "get",
        "data":{
          'filterColumn' : filter
        },
      },
      'columnDefs': [
        {
          'targets': 0,
          'checkboxes': {
            'selectRow': true,
          },
          render: function(data, type) {
            return type === 'display'? '<input class="dt-checkboxes form-check-input" type="checkbox">' : '';
          }
        }
      ],
      'select': {
          'style': 'multi',
          'blurable': true
      },
      dom: 'Blfrtip',
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All'],
      ],
      search: {
          smart: true
      },
      buttons: [
          {
            text: '<button class="dt-button buttons-collection buttons-colvis me-1" id="exportDatatable" title="Export">Export</button>',
            action: function () {
                return true;
            }
          },
          {
            text: '<button class="dt-button buttons-collection buttons-colvis me-1" title="Print">Print</button>',
            action: function () {
              window.print();
            }
          },
          {
            extend: 'colvis',
            text: "Hide Column",
            columnText: function(dt, idx, title){
                return "<i class='bx bx-check'></i>"+title;
            },
          },
          {
            text: `<span class="btn-delete-datatable-row py-0" style="display:none;">${buttonText}<span class="bx bx-trash mb-1 bg-red"/></span>`,
            action: function () {
              var rows_selected = table.column(0).checkboxes.selected();
              var rows = [];
              $.each(rows_selected, function(index,rowId){
                rows.push(rowId);
              });
              $("#dialog-confirm" ).dialog({
                resizable: false,
                modal: true,
                responsive: true,
                buttons: {
                  Delete: function() {
                    $(this).dialog("close");
                    $.ajax({
                      url: 'http://192.168.100.135/cna/delete/rows',
                      type: 'get',
                      data: {
                        'rows': rows,
                        'table' : db_table
                      },
                      success: function(data) {
                        rows = [];
                        table.ajax.reload();
                        $('.btn-delete-datatable-row').hide();
                        if(data.msg === '419'){
                          $(`<div title='Unathorized'><i class="bx bx-error" style="float:left; margin:12px 12px 20px 0;color:#cd5c5c;"></i>You are not authorized to delete ${db_table.toLowerCase()} data.</div>`).dialog();
                        }else{
                          $(`<div title='Success'><i class="bx bx-happy-heart-eyes" style="float:left; margin:12px 12px 20px 0;color:#cd5c5c;"></i>Selected data successfully removed.</div>`).dialog();
                        }
                      }
                    });
                  },
                  Cancel: function() {
                    $(this).dialog("close");
                    $('.btn-delete-datatable-row').hide();
                  }
                }
              });
            }
          }
      ],
      columns: data,
  });

  $(".dt-checkboxes-select-all").on('click', function(e){
    const checked = e.target.checked;
    checked ? $('.btn-delete-datatable-row').show() : $('.btn-delete-datatable-row').hide();
  });
  
  $('body').on('click','.table', function(e){
    $(this).prop('checked', $(this).prop('checked'));
    var table_row = $('.data-table').find('input[type=checkbox]:checked').length;
    table_row > 0 ? $('.btn-delete-datatable-row').show() : $('.btn-delete-datatable-row').hide();
  });
  
  if(func){
    $('.data-table tbody').on('click', '.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
        if ( row.child.isShown() ) {
          row.child.hide();
          tr.removeClass('shown');
        }
        else {
          row.child(func(row.data())).show();
          tr.addClass('shown');
        }
    });
  }
}