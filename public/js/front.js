$('#btnSendSub').click(function(){
    
    var txtEmailSub = $('#txtEmailSub').val();
    var _token = $('#_token').val();
    
//check email trống-----------
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(txtEmailSub) == false) 
        {
            alert('Email không hợp lệ, vui lòng kiểm tra lại.');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: url + "/dang-ky-nhan-tin-khuyen-mai",
            data: { 
                txtEmailSub: txtEmailSub, 
              
              _token: _token 
            },
            success: function(data) {
                 if(data == 'error_exit_email'){
                     alert('Email này đã tồn tại, vui lòng kiểm tra lại!');

                 }else if(data == 'error'){ 
                    alert('Có lỗi, vui lòng kiểm tra lại!');


                 }else{
                     alert('Đăng kí nhận tin khuyến mãi thành công')
                 }
           
      },
    });

});

$('#btnSendContact').click(function(){
    var txtEmail = $('#txtEmail').val();
    
    var txtName = $('#txtName').val();
    var txtPhone = $('#txtPhone').val();
    var txtMessage = $('#txtMessage').val();
    var _token = $('#_token').val();
    if(txtEmail==''||txtName==''||txtPhone==''||txtMessage==''){
        alert('Vui lòng điền đầy đủ thông tin');
        return false;
    }
    
//check email trống-----------
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(txtEmail) == false) 
        {
            alert('Email không hợp lệ, vui lòng kiểm tra lại.');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: url + "/gui-email-lien-he",
            data: { 
                txtEmail: txtEmail, 
                txtName: txtName,
                txtPhone: txtPhone,
                txtMessage: txtMessage,
              _token: _token 
            },
            success: function(data) {
                if(data == 'error_empty'){ 
                    alert('Có lỗi, vui lòng kiểm tra lại!');


                 }else if(data == 'error'){
                    alert('Có lỗi, vui lòng kiểm tra lại!');
                 }
                 else{
                     alert('Đã nhận được email liên hệ và sớm liên lạc.')
                 }
           
      }
    });
});

// sắp xếp theo tin
$('#newsSort').on('change', function(){
    var cat = $('#newsCat').val();
    var sort = this.value;
    if(sort !=''){
        window.location.href= url+"/"+cat+"/?sapxep="+sort;
    }
});



