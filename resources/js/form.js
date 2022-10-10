(function ($) {  

 $('body').on('shown.bs.modal', '.modal', function() {
  $('#datepicker2').datepicker(
      {
        format: 'yyyy-mm-dd',
        autoclose:true,
          todayBtn:'linked',
          todayHighlight:true,
          clearBtn:true,
          leftArrow: '<i class="fa-solid fa-circle-chevron-left"></i>',
          rightArrow: '<i class="fa-solid fa-circle-chevron-right"></i>',
          container:'#editModal .modal-body',
      });
    
  $(this).find('select#experiences2').each(function() {
    var dropdownParent = $(document.body);
    if ($(this).parents('.modal.in:first').length !== 0)
      dropdownParent = $(this).parents('.modal.in:first');
    $(this).select2({
      dropdownParent: $('#editModal .modal-body'),
      placeholder: 'update your selection',
       allowClear: true,
      // ...
    });
  });
});

    $(document).on('click','.employeeEdit', function(){
            let employee_id = $(this).val();

            //alert(employee_id );

            $.ajax({
                type:'GET',
                url:'show.php?employee_id='+ employee_id,

                success:function(response){
                    let res = JSON.parse(response);
                  

                    if(res.status ==422){
                    alert(res.message);
                }
                else if(res.status ==200)
                {

                 $('#editModal').modal('show');

                    let valueAreas = res.data.experience;
                    let valueArray = valueAreas.split(',');
                  $('#employee_id').val(res.data.ID);
                  $('#Name').val(res.data.name);
                  $('#ctc').val(res.data.ctc);
                  $('#datepicker2 input').val(res.data.dob);
                  $('#datepicker2 input').datepicker();
                  $('select#experiences2').val(valueArray);
                  $('select#experiences2').select2().trigger('change');
                   }
                }
                
            });
    });


    // view employee data

        $(document).on('click','.viewEmployee', function(){
            let employee_id = $(this).val();

            //alert(employee_id );

            $.ajax({
                type:'GET',
                url:'show.php?employee_id='+ employee_id,

                success:function(response){
                    let res = JSON.parse(response);
                  

                    if(res.status ==422){
                    alert(res.message);
                }
                else if(res.status ==200)
                {
                 $('#viewModal').modal('show');
                  $('#employee_id').text(res.data.ID);
                  $('#view_name').text(res.data.name);
                  $('#view_ctc').text(res.data.ctc);
                  $('#view_dob').text(res.data.dob);               
                  $('#view_exp').text(res.data.experience);
                
                   }
                }
                
            });
    });

     $(document).on('submit','#updateEmployee',function(e){
        e.preventDefault();

        let formData = new FormData(this);

        formData.append("update_employee",true);

        $.ajax({
            type:'POST',
            url:'show.php',
            data: formData,
            processData:false,
            contentType:false,

            success:function(response){
               let res = JSON.parse(response);

                if(res.status == 422){
                    $('#errorMessageUpdate p').removeClass('d-none');
                   // $('#errorMessageUpdate p').text(res.message);
                     $('#editModal').modal('hide');
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(res.message);
                }else if(res.status == 200){
                     $('#errorMessageUpdate p').addClass('d-none');
                    // $('select#experiences2').val('').trigger('change');
                    $('#errorMessageUpdate p').text(res.message);
                    $('#updateEmployee')[0].reset();
                    
                     $('#editModal').modal('hide');
                     alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);
                     
                     $('#employeeDatatable').load(location.href + " #employeeDatatable");
                }
            }

        });
    });

    })(jQuery);

    
   