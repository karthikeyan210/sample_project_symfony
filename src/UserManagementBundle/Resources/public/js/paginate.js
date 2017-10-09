function changePagination(pageId){
//    var url = '{{ path('user_management_paginate')}}'+'/'+pageId;
    var url = 'users/paginate/'+pageId;

    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(result){
            console.log(result);
            var elem =  document.getElementById('displayResults');
            elem.innerHTML = "";
            elem.innerHTML = result;
        }
    });
}