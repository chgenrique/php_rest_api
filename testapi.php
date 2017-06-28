<!DOCTYPE html>
<html>
    <head>
        <script src="assets/jquery-3.2.1.js"></script>
    </head>
    <body>

        <div>
            <form action='http://localhost/php_rest_api/api.php' method='POST'>
                <h3>Add department using API-POST</h3>
                <input type="text" placeholder="Department Name" name="department_name">
                <button type="submit">Add</button>
            </form>
        </div>
        <br>

        <div>
            <form action='http://localhost/php_rest_api/api.php' method='GET'>
                <h3>Get department(s) using API-GET</h3>
                <input type="text" placeholder="Id of department" name="department_id">
                <button type="submit">GET ELEMENT</button>
            </form>
        </div>
        
        <br>
        <div>
            <form action="#">
                <h3>Update department using API-PUT</h3>
                <input type="text" name="id_dpto" placeholder="Id of department">
                <input type="text" name="department" placeholder="Department">
                <input type="button" value="PUT" name="updateDpto">
            </form>
        </div>
        
        <br>
        <div>
            <form action="#">
                <h3>Delete department using API-DELETE</h3>
                <input type="text" name="id_dpto_delete" placeholder="Id of department">
                <input type="button" value="DELETE" name="deleteDpto">
            </form>
        </div>
        
        
        <script type="text/javascript">
 
            $('input[name="deleteDpto"]').click(function(){
                
                var dataSend = {department_id: $('input[name="id_dpto_delete"]').val()};

                $.ajax({
                    url: 'http://localhost/php_rest_api/api.php'+ '?' + $.param(dataSend),
                    type: 'DELETE',
                }).done(function(data){
                   if(data.status === 200){
                       alert(data.status_message);
                   } else
                       alert('Some errors has ocurred. '+ data.status_message);
                });
            });
            
            $('input[name="updateDpto"]').click(function(){
                var dataSend = {department: $('input[name="department"]').val(), department_id: $('input[name="id_dpto"]').val()};
                $.ajax({
                    url: 'http://localhost/php_rest_api/api.php',
                    type: 'PUT',
                    data: dataSend
                }).done(function(data){
                    if(data.status === 200){
                       alert(data.status_message);
                   } else
                       alert('Some errors has ocurred. '+ data.status_message);
                });
            });
            
        </script>
    </body>
</html>