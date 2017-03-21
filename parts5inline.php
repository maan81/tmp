<!DOCTYPE>
<html>
    <head>
        <title>HTML5 Inline editing using MySQL,PHP,jQuery and Ajax - <MyCodingTricks/></title>
        <link href="http://mycodingtricks.com/demo/style.css" rel="stylesheet"/>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row nav"></div>
        <div class="row"><p align="center" rel="advertisements"></p></div>
        <div class="row">
            <div class="col-md-3" rel="advertisements"></div>
            <div class="col-md-6">
                <h1>HTML5 Inline Editing</h1>
                <div class="alert hide"></div>
                <table class="table">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Username</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td contenteditable="true" id="fname:1">Shubham</td>
                        <td contenteditable="true" id="lname:1">Kumar</td>
                        <td contenteditable="true" id="uname:1">shubhammct</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td contenteditable="true" id="fname:2">Shyam</td>
                        <td contenteditable="true" id="lname:2">Srivastava</td>
                        <td contenteditable="true" id="uname:2">srishyam</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td contenteditable="true" id="fname:3">Ram</td>
                        <td contenteditable="true" id="lname:3">Kinkar</td>
                        <td contenteditable="true" id="uname:3">ramkin</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3" rel="advertisements"></div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
           $("td[contenteditable=true]").blur(function(){
               var msg = $(".alert");
               var newvalue = $(this).text();
               var field = $(this).attr("id");
               $.post("update.php",field+"="+newvalue,function(d){
                   var data = jQuery.parseJSON(d);
                   msg.removeClass("hide");
                    if(data.status == 200){
                        msg.addClass("alert-success").removeClass("alert-danger");
                    }else{
                        msg.addClass("alert-danger").removeClass("alert-success");
                    }
                   msg.text(data.response);
                   setTimeout(function(){msg.addClass("hide");},3000);//It will add hide class after 3 seconds
               });
           });
        });
    </script>
    </body>
</html>