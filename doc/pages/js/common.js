/**
 * Created by wei_jc on 2015/3/15.
 */
$.validator.setDefaults({
    errorClass: 'text-error',
    invalidHandler: function (event, validator) { //display error alert on form submit
        for(var i = 0; i < validator.errorList.length; i++) {
            $(validator.errorList[i].element).tooltip({
                html: true,
                placement: 'top',
                title: validator.errorList[i].message,
                trigger: 'focus '
            });
        }
    },
    /*highlight: function (element) { // hightlight error inputs
        $(element).addClass('text-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change dony by hightlight
        $(element).removeClass('text-error');
    },
    success: function (label, element) {
        label.closest('.control-group').removeClass('error');
        label.remove();
    },*/
    errorPlacement: function (error, element) {
        //error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
    }
});