$(document).ready(function(){
    $("#addattraction").click(function(){
        if($("#insertform").is(":visible")){
            $("#insertform").hide();
        } else {
            $("#insertform").show();
        }
        //don't follow the link (optional, seen as the link is just an anchor)
        return false;
    });

    $("#login").click(function(){
        if($("#loginform").is(":visible")){
            $("#loginform").hide();
        } else {
            $("#loginform").show();
        }
        //don't follow the link (optional, seen as the link is just an anchor)
        return false;
    });


    $('form#insertform').submit(function(event){
        $.ajax({
            type: "POST",
            url: "/index.php?__path=/transactions.json",
            data: {
                amount: $(this).find('input[name=amount]').val(),
                currency: "USD",
                merchant: $(this).find('input[name=merchant]').val(),
                created_at: $(this).find('input[name=created_at]').val()
            },
            success: function(data, _status, _xhr){
                console.log(data);
                alert('Transaction Success');
                $('form#insertform').hide();
                getAllData();
            },
            error: function(xhr, status, error_thrown){
                // TODO: Handle errors
                console.log(xhr);
                console.log(status);
                console.log(error_thrown);
            },
            dataType: "json"
        });

        event.preventDefault();
    });

    $('form#loginform').submit(function(event){

        $.ajax({
            type: "POST",
            url: "/index.php?__path=/login.json",
            data: {
                user_id: $(this).find('input[name=user_id]').val(),
                user_secret: $(this).find('input[name=user_secret]').val()
            },
            success: function(data, _status, _xhr){
                alert('Login Success');
                $('form#loginform').hide();
                getAllData();
            },
            error: function(xhr, status, error_thrown){
                // TODO: Handle errors
                console.log(xhr);
                console.log(status);
                console.log(error_thrown);
            },
            dataType: "json"
        });

        event.preventDefault();
    });

    function add_tx_row(row) {
        $('table#transactions').append("<tr class='data'><td>" + row['currency'] +  "</td><td>"+ row['amount'] +"</td><td>" + row['created'] +"</td></tr>");
    }

    function getAllData() {
        $('table#transactions tr.data').empty().remove();
        $.getJSON("/index.php?__path=/transactions.json", function(data){
            var rows = data['transactionList'];
            for(var i = 0; i < rows.length; i++) {
                add_tx_row(rows[i]);
            }
        });
    }

});
