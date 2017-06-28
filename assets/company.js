$(document).ready(function(){
   var div1 = $('<div/>').appendTo('body');
   div1.attr('id','divOffice');
   div1.css('float','left');
   
   div1.append('<h3>Management Departments</h3>');
   
   
$('<form name="formStaff" action="#" method="get">'+
'<label>Department name:</label> <input type="text" name="officeName" /><br/><br/>'+
'<input type="button" id="addOffice" value="Add department" />'+
'</form>').appendTo(div1);
   
   div1.append('<table id="tableOffice" width="100%" border="1"><tr><td>Checkbox</td><td>Name</td></tr></table>');
   div1.append('<br><input type="button" id="removeOfficeBtn" value="Remove">');
   
   var div2 = $('<div/>').appendTo('body');
   div2.attr('id','divStaff');
   div2.css('float','right');
   
   div2.append('<h3>Staff Member</h3>');
   
   $('<form name="formStaff" action="#" method="get">'+
'<label>Staff member name:</label> <input type="text" name="memberName" id="memberName"/><br/><br/>'+
'<label>Department name:</label> <select name="officeNameStaff" id="officeNameStaff"><option value="0">--Select--</option></select><br/><br/>'+
'<label>Date of hire:</label> <input type="date" name="hireDate" id="hireDate"/><br/><br/>'+
'<input type="button" id="addStaffMember" value="Add staff member" />'+
'</form>').appendTo(div2);

 div2.append('<table id="tableStaff" width="100%" border="1"><tr><td>Checkbox</td><td>Staff member name</td><td>Office name</td><td>Date of hire</td></tr></table>');
 div2.append("<br><input type='button' id='deleteStaffMemberBtn' value='Fire'>");

loadInitDepartments();
$('#addOffice').click(function(){
    addDepartment();
    clearForm();
});

$('#addStaffMember').click(function(){
    addStaffMember();
    clearForm();
});

$('#removeOfficeBtn').click(function(){
    
    confirmDialog('Are you sure you want to remove the department(s)?',1);
});

$('#deleteStaffMemberBtn').click(function(){
     confirmDialog('Are you sure you want to remove the staf(s) member(s)?',2);
});

}); // End of document ready



// Functions

function loadInitDepartments()
{
    var dataArr = {operation:'getInitialData'};
    
    $.ajax({
        type: 'GET',
        url: 'app/ajaxTest.php',
        data: dataArr,
        dataType: "json"    
    }).done(function(data){
        if(data){
            for(var i = 0; i < data.length; i++)
            {
                $('#tableOffice').append("<tr><td><input type=\"checkbox\" name='officeCheck' id=\"ckbox-"+data[i][0]+"\" value=\""+data[i][0]+"\"></td><td>"+data[i][1]+"</td></tr>");
                var officeNameStaff = $('select[name="officeNameStaff"]');
                officeNameStaff.append('<option value="'+data[i][0]+'">'+data[i][1]+'</option>'); 
            }
        }
    });
}

function addDepartment()
{
    var officeName = $('input[name="officeName"]').val(); // Another method access, by name
    if(officeName){
        if(checkUnique(officeName)){
            var dataDpto = {office: officeName, operation:'addOffice'};
            $.ajax({
                type: 'POST',
                url: 'app/ajaxTest.php',
                data: dataDpto,
                dataType: "json"
            }).done(function(data){
                if(data.length > 0){
                    deleteElementsTable('tableOffice');
                    var officeNameStaff = $('select[name="officeNameStaff"]');
                    officeNameStaff.empty();
                    officeNameStaff.append('<option value="0"> -- Select -- </option>'); 
                    for(var i = 0; i < data.length; i++)
                    {
                        $('#tableOffice').append("<tr><td><input type=\"checkbox\" name='officeCheck' id=\"ckbox-"+data[i][0]+"\" value=\""+data[i][0]+"\"></td><td>"+data[i][1]+"</td></tr>");
                        
                        officeNameStaff.append('<option value="'+data[i][0]+'">'+data[i][1]+'</option>'); 
                    }
                }else alert('Have occurred some error when try insert new office');
            });           
        }else alert('The department name must be unique.');
        
    }else
    {
        alert('The department name must be specifying.');
    }
}

function addStaffMember()
{
    var memberName = $('#memberName').val(); // access to id
    var departmentId = $('select[name="officeNameStaff"] option:selected').val();
    var hireDate = $('#hireDate').val();
    if(departmentId !== '0' && memberName){
        
        
        var dataArr = {memberName: memberName, departmentId: departmentId, hireDate:hireDate, operation:'addMember'};
            $.ajax({
                type: 'POST',
                url: 'app/ajaxTest.php',
                data: dataArr,
                dataType: "json"
            }).done(function(data){
                if(data.length > 0){
                    deleteElementsTable('tableStaff');
                    for(var i = 0; i < data.length; i++)
                    {
                        $('#tableStaff').append("<tr><td><input type=\"checkbox\" name='officeCheck' id=\"ckbox-"+data[i][0]+"\" value=\""+data[i][0]+"\"></td><td>"+data[i][1]+"</td><td>"+data[i][2]+"</td><td>"+data[i][3]+"</td></tr>");
                    }
                }else alert('Have occurred some error when try insert new office');
            });
    }else
        alert('Staff members cannot be created/entered without specifying the office in which they work.');
}

function deleteElementsTable(table)
{
    $("#"+table).find("tr:not(:first)").remove();
}

function deleteDepartmentRow()
{
    var arrayCheck = [];
     $('div#divOffice input[type=checkbox]').each(function () {
         if($(this).is(':checked'))
         {
            arrayCheck.push($(this).attr('value'));
         }
        });
      
      var dataArr = {dptoToDelete: arrayCheck, operation:'deleteDpto'};
      $.ajax({
        type: 'POST',
        url: 'app/ajaxTest.php',
        data: dataArr,
        dataType: "json"     
      }).done(function(data){
        if(data.status === 'ok'){
            $('div#divOffice input[type=checkbox]').each(function () {
                if($(this).is(':checked'))
                {
                   $(this).parents("tr").remove();
                }
            });
          
            var arrayOfficesDel = [];
            for(var i=0; i < arrayCheck.length; i++)
            {
              var toDelete = $('select[name="officeNameStaff"] option[value="'+arrayCheck[i]+'"]');
              arrayOfficesDel.push(toDelete.text());
              toDelete.remove();
            }

            $('#tableStaff tr').each(function() {
                var nameElem = $(this).find('td').eq(2).text();
                if($.inArray(nameElem,arrayOfficesDel)>=0)
                {
                  $(this).closest('tr').remove();
                }
              });
          }
      });
}

function deleteStaffMemberRow()
{
    var arrayCheckToDelete = [];
    $('div#divStaff input[type=checkbox]').each(function () {
         if($(this).is(':checked'))
         {
            arrayCheckToDelete.push($(this).attr('value'));
         }
        });
        
      var elementToDel = {memberToDelete: arrayCheckToDelete, operation:'deleteMember'};
      $.ajax({
        type: 'POST',
        url: 'app/ajaxTest.php',
        data: elementToDel,
        dataType: "json"     
      }).done(function(data){
          if(data.status === 'ok'){
              $('div#divStaff input[type=checkbox]').each(function () {
                if($(this).is(':checked'))
                {
                   $(this).parents("tr").remove();
                }
               });
          }
      });
}

function checkUnique(nameOffice)
{
    var allNames = [];
    $('#tableOffice tr').each(function() {
        var found = $(this).find('td').eq(1).text();
        if(found)
        allNames.push(found);
      });
      
      if($.inArray(nameOffice.trim(),allNames)>=0)
        {
          return false;
        }
    return true;
}


function confirmDialog(message,type) {
    $('<div></div>').appendTo('body')
                    .html('<div><h3>'+message+'</h3></div>')
                    .dialog({
                        autoOpen : true,
                        width : 410,
                        height : 250,
                        show : 'blind',
                        hide : 'explode',
                        modal: true, title: 'Delete message', zIndex: 10000,
                        resizable: false,
                        buttons: {
                            'Yes': function () {
                                if(type===1)
                                {
                                   deleteDepartmentRow(); 
                                }else if(type===2)
                                {
                                    deleteStaffMemberRow();
                                }
                                $(this).dialog("close");
                            },
                            'No': function () {                                                                 

                                $(this).dialog("close");
                            }
                        },
                        close: function () {
                            $(this).remove();
                        }
                    });
};

function clearForm()
{
    $(':input').not(':button, :submit, :reset, :hidden, :radio, :checkbox').val('');
    $('select[name="officeNameStaff"]').prop('selectedIndex', 0).trigger("chosen:updated");
}