/**
 * Created with JetBrains PhpStorm.
 * User: fedmest
 * Date: 15/12/2012
 * Time: 18:12
 * To change this template use File | Settings | File Templates.
 */

$(function() {
    $("span[rel=tooltip]").tooltip();
    $('#registerModal').on('show', function() {
        $("#formRegisterProgress").hide();
        $("#serverRegisterErrorAlert").hide();
        $("#serverRegisterSuccessAlert").hide();
        $("#formRegisterErrorAlert").hide();
        $("#profileForm").show();
        $("#profileSave").show();
        $("#profileSave").removeAttr("disabled");
        $("#profileCanc").html("Cancel");
    });
    $("#profileSave").on("click", function(event) {
        $(this).attr("disabled", "disabled");
        $("#serverRegisterErrorAlert").hide();
        $("#formRegisterErrorAlert").hide();
        $("#formRegisterProgress").show();
        $.ajax({
            type: 'POST',
            url: 'register.php',
            data: $("#profileForm").serialize(),
            success: profileSaveSuccess,
            error: profileSaveError,
            dataType: 'json'
        });
        return false;
    });
});

function profileSaveSuccess(data, status, obj) {
    $("#formRegisterProgress").hide();
    var msg = null;
    switch ( data.status ) {
        case 'created':
            $("#profileForm").find("input:text, input:password").val("");
        case 'saved':
            $("#serverRegisterSuccessAlert").show();
            $("#profileForm").hide();
            $("#profileSave").hide();
            $("#profileCanc").html("Close");
            break;
        case 'missing':
            msg = 'You have to fill in all the fields in the form';
            break;
        case 'password':
            msg = 'The password and confirmation password do not match.';
            break;
        case 'exists':
            msg = 'Sorry, but this Plugin ID is already registered.';
            break;
        case 'unsaved':
            msg = 'Could not save your data into the database.';
            break;
    }
    if ( msg ) {
        $("#profileSave").removeAttr("disabled");
        $("#formRegisterErrorMessage").html(msg);
        $("#formRegisterErrorAlert").show();
    }
}

function profileSaveError(obj, status, ex) {
    $("#formRegisterProgress").hide();
    $("#profileSave").removeAttr("disabled");
    $("#serverRegisterErrorAlert").show();
}
