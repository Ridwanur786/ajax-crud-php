(function ($) {

  $('body').on('shown.bs.modal', '.modal', function () {
    $('#datepicker1').datepicker({
      format: 'yyyy-mm-dd',
      title: 'Please Select Date',
      orientation: 'vertical',
      autoclose: true,
      todayBtn: 'linked',
      todayHighlight: true,
      clearBtn: true,

      prev: '<i class="fa-solid fa-circle-chevron-left"></i>',
      next: '<i class="fa-solid fa-circle-chevron-right"></i>',


      container: '#ajaxModal .modal-body',

    });

    $(this).find('select#experiences').each(function () {
      var dropdownParent = $(document.body);
      if ($(this).parents('.modal.in:first').length !== 0)
        dropdownParent = $(this).parents('.modal.in:first');
      $(this).select2({
        dropdownParent: $('#ajaxModal .modal-body'),
        placeholder: 'select tech experiences',
        allowClear: true,
        // ...
      });
    });
  });

  $(document).on('submit', '#addEmployee', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    formData.append("save_employee", true);

    $.ajax({
      type: 'POST',
      url: 'show.php',
      data: formData,
      processData: false,
      contentType: false,

      success: function (response) {
        let res = JSON.parse(response);

        if (res.status == 422) {
          $('#errorMessage p').removeClass('d-none');
          $('#errorMessage p').text(res.message);
        } else if (res.status == 200) {
          $('#errorMessage p').addClass('d-none');
          $('select#experiences').val('').trigger('change');
          $('#errorMessage p').text(res.message);
          $('#addEmployee')[0].reset();
          alertify.set('notifier', 'position', 'top-right');
          alertify.success(res.message);
          $('#ajaxModal').modal('hide');
          $('#employeeDatatable').load(location.href + " #employeeDatatable");
        }
      }

    });
  });

  $(document).on('click', '.deleteEmployee', function (e) {
    e.preventDefault();

    let employee_id = $(this).val();

    alertify.confirm('Are You Sure to Delete This Record?', function (asc) {
      $.ajax({
        type: 'POST',
        url: 'show.php',
        data: {
          'employee_id': employee_id,
          'delete_employee': true
        },       
        success: function (response) {
          let res = JSON.parse(response);

          if (asc) {
            if (res.status == 500) {
               alertify.set('notifier', 'position', 'top-right');
              alertify.error(res.message);
            } else {
               alertify.set('notifier', 'position', 'top-right');
              alertify.success(res.message);
              $('#employeeDatatable').load(location.href + " #employeeDatatable");
            }
          }


        }
      });


    });

  });


})(jQuery);