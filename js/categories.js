$(document).ready(function(){
    //append added categories to the "Choose category" selection list
    categories = [];
    $(".new_categories").each(function(){
      categories.push($(this).text());
    });

    $.each(categories, function(index, value){
      $('#categories_options').append($('<option/>', {
        value: value,
        text: value
      }));
    });

});
