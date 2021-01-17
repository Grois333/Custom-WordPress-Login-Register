
function _(id){ return document.getElementById(id); }
function submitForm(){

        _("submitBtn").disabled = true;
        _("status").innerHTML = '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>';
    
}