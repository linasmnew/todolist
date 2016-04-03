$(document).ready(function(){

var checked = [];

$('.selected_task').change(function(){
  var preparedChecked = '';
  //re-set "checked" to prevent multiple instances of the same values
  //could refactor this to add a check below to see if a value is already
  //inside the array before pushing it
  checked = [];
  var checkBoxes = $('.selected_task');

  for(var i=0; checkBoxes[i]; i++){
    if(checkBoxes[i].checked){
      checked.push(checkBoxes[i].value);
    }
  }

  preparedChecked = checked.join("&");
  $('#complete_task_link').attr('href',preparedChecked);
  $('#remove_task_link').attr('href',preparedChecked);
});


function ajaxErrors(xhr, error){
  console.log('error executed');
  if(xhr.status === 0){
    flagUser('connectionError');
    console.log('not connected, verify network connection');
  }else if(xhr.status == 404){
    console.log('requested page not found 404');
  }else if(xhr.status == 500){
    console.log('internal server error 500');
  }else if(error === 'timeout'){
    console.log('time out errro');
  }else if(error === 'abort'){
    console.log('ajax request aborted');
  }else{
    console.log('uncaught error');
  }
}


$('#complete_task_link').click(function(evt){
  evt.preventDefault();
  var urlCompleteTask = $("#complete_task_link").attr('href');
  var data = {"markUrl": urlCompleteTask};
  jQuery.ajax({
    type: 'POST',
    url: 'mark-as-completed.php',
    data: data,
    cache: false,
    error: function(xhr, error){
      ajaxErrors(xhr, error);
    },
    success: function(response){
      //remove item from the dom
      $('.selected_task').each(function(){
        var inputtt = $(this).val();

        if($.inArray(inputtt, checked) !== -1 ){
          //found
          $(this).closest('div').remove();
        }
      });
      //reset id values
      $('#complete_task_link').attr('href','javascript:;');
      $('#notice').css('display','block');
      $('#notice').text('Marked as completed');
    }

  });

});





$('#remove_task_link').click(function(evt){
  evt.preventDefault();
  var urldeletetask = $("#remove_task_link").attr('href');
  var data = {"removeUrl": urldeletetask};
  jQuery.ajax({
    type: 'POST',
    url: 'remove-task.php',
    data: data,
    cache: false,
    error: function(xhr, error){
      ajaxErrors(xhr, error);
    },
    success: function(response){
      //remove item from the dom
      $('.selected_task').each(function(){
        var inputtt = $(this).val();

        if($.inArray(inputtt, checked) !== -1 ){
          //found
          $(this).closest('div').remove();
        }
      });
      //reset id values
      $('#remove_task_link').attr('href','javascript:;');
      $('#notice').css('display','block');
      $('#notice').text('Removed');
    }

  });

});




$('.delete_category_link').click(function(evt){
  evt.preventDefault();
  var categoryId = $(this).attr('href');
  var categoryElement = $(this);
  var data = {"categoryId": categoryId};
  console.log(categoryId);
  jQuery.ajax({
    type: 'POST',
    url: 'remove-category.php',
    data: data,
    cache: false,
    error: function(xhr, error){
      ajaxErrors(xhr, error);
    },
    success: function(response){

      //removing the deleted category from "Choose category" select options
      var elemn = categoryElement.siblings('a').text();

      $('#categories_options option').each(function(){

        if($(this).val() == elemn){
          $(this).remove();
          console.log('removedddd');
        }

      });

      categoryElement.closest('li').remove();

    }

  });

});


});//end of document ready
