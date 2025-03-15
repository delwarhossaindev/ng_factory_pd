const selectPermission = param => {
  $('input[id='+param+']').prop('checked', $('.'+param+'').prop('checked'));
}
$('body').on('click','#selectAll',function(e){
    var clicks = $(this).data('clicks');
    $("input[class=form-check-input]").prop('checked', $(this).prop('checked'));
    if (clicks) {
        $('#replace').html('Select All');
    } else {
        $('#replace').html('Unchek All');
    }
    $(this).data("clicks", !clicks);
});
document.addEventListener("DOMContentLoaded", function() {
  if($.ui){
    $.ui.dialog.prototype._focusTabbable = function(){};
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach((form) => {
      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
      var dialog;
      dialog = $( "#dialog-form" ).dialog({
        autoOpen: false,
        width: 450,
        height: ($(window).height() - 400),
        resizable: false,
        modal: true,
        responsive: true,
      });
      $("#create-new").button().on("click", function() {
        dialog.dialog("open");
      });
    });
  }else{
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach((form) => {
      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }

  $('body').on('click','.ui-dialog-titlebar-close',function(e){
    e.preventDefault();
    $('.needs-validation')
        .trigger("reset")
        .removeClass('was-validated')
    $('#download').hide();
    $('.loader').hide();
  });
});
$("body").on("click",".show_confirm",function(event){
  var form =  $(this).closest("form");
  event.preventDefault();
  $( "#dialog-confirm" ).dialog({
    resizable: false,
    modal: true,
    responsive: true,
    buttons: {
      Delete: function() {
        form.submit();
      },
      Cancel: function() {
        $( this ).dialog( "close" );
      }
    }
  });
});
$('body').on('click', '.ajax-modal-btn', function(e) {
  e.preventDefault();
  var url = $(this).data('link');
  $.get(url, function(data) {
    $('.edit-modal').html(data)
    var dialog;
    dialog = $("#dialog-form").dialog({
      autoOpen: false,
      width: 450,
      height: ($(window).height() - 400),
      resizable: false,
      modal: true,
      responsive: true,
    });
    dialog.dialog("open");
  })
});

$('body').on('click', '#exportDatatable', function(e) {
    var dialog;
    dialog = $("#export-form-datatable").dialog({
      autoOpen: false,
      width: 450,
      height: ($(window).height() - 400),
      modal: true,
    });
    dialog.dialog("open");
});
document.addEventListener("DOMContentLoaded", function() {
  $('#output').hide();
  $('.dt-buttons').addClass('d-flex');
  $('input:checkbox').addClass('form-check-input');
  $('input.dt-checkboxes').addClass('form-check-input');
});

$('body').on('click','.selected_all_row', function(e){
  $(".selected_row_column").prop('checked', $(this).prop('checked'));
  $('#checkbox_error').hide();
})

$('body').on('click','.selected_row_column', function(e){
  $('#checkbox_error').hide();
})

$('body').on('click','#export',function(e){
  e.preventDefault();
  var row_count = $('.export-form').find('input[type=checkbox]:checked').length;
  if(row_count == '0') {
    $('#checkbox_error').show();
    return false;
  }
  $('#loader').show();
  var ids = [];
  var db_table = $('#db_table').val();
  $('input[id="selected_column"]:checked').each(function() {
     ids.push(this.value);
  });
  const date_from = $('#date_form').val();
  const date_to   = $('#date_to').val();
  $.ajax({
    url: 'http://192.168.100.135/cna/export?rows='+ids+'&db_table='+db_table+'&date_from='+date_from+'&date_to='+date_to,
    type:'get',
    success: function(res){
      $('#loader').hide();
      const link = document.createElement("a");
      link.href = res;
      link.download = 'data.csv';
      link.click();
    }
  })
});

// $('body').on('click','.dtr-control', e => {
//   $('.dt-checkboxes-cell').css('display','none');
// });

// $('body').on('click','.ui-dialog-titlebar-close', e => {
//   $('.dt-checkboxes-cell').css('display','');
//   $('.btn-delete-datatable-row.py-0').css('display','none');
// });

$('body').on('click','.filter-row', e => {
  const data = $('.filter-form').serialize();
  generate_datatable(route,columns,order,button,deleteButtonText, table,data);
});

const multi_selectable_dropdown = data => {
  $('.select2').select2({
    theme: "classic",
    placeholder: '',
    minimumInputLength: 1,
    ajax: {
      url: window.location.origin + '/' + route,
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
            results: $.map(data, function (item) {
                return {
                    text: item.name,
                    id: item.id
                }
            })
        };
      },
      cache: true
    }
  });
}

const multi_selectable_dropdown_with_tag = (route) => {
  $('.select2').select2({
      theme: "classic",
      placeholder: '',
      minimumInputLength: 1,
      ajax: {
        url: window.location.origin + '/' + route,
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      },
      tags:true,
      allowClear: true,
      tokenSeparators: [','],
      insertTag: function (data, tag) {
        data.push(tag);
      },
  });
}

const tagify_generator = () => {
  var input = document.querySelector("#TagifyBasic");
  tagify = new Tagify(input);
}

const numberOnly = evt => {
  var theEvent = evt || window.event;
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

const imageOnly = evt => {
  var fileName = document.getElementById("image").value;
  var idxDot = fileName.lastIndexOf(".") + 1;
  var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
  if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
      return true;
  }else{
      alert("Only jpg/jpeg and png files are allowed!");
      document.getElementById("image").value = "";
  }
}
