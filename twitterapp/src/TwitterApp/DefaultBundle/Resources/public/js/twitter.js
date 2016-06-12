function unixToHumanReadable(unixTimeStamp){ //function to convert our unix timestamp value to human readable
    var readable = new Date(); 
    readable.setTime(unixTimeStamp * 1000);  
    return readable.toUTCString();
}

window.onload = function(){ //This makes sure this function will only run once jQuery (and the rest of the DOM objects) are loaded
    $("#submitBtn").click(function(e){
        e.preventDefault();

        $.ajax({ //Build our AJAX call
            type: "POST",
            url: "/twitter/",
            data: {
              searchStr: $("#searchInpt").val() //grab our search text
            },
            dataType: "text",
            beforeSend: function() {
                $("#resultsCntr").slideUp("slow");
            },
            success: function(response) {
                $("#resultsCntr").empty(); //Clear any existing results

                var jsonArray  = jQuery.parseJSON(response);

                if($.isEmptyObject(jsonArray)) { //very basic error handling.
                    alert("No results found. Enter a new query and try again.");
                }

                $.each(jsonArray, function(key, value) {
                    $("#resultsCntr").append('<blockquote><p>'+value.text+'</p><footer><cite title="Source Title">'+value.handle+'</cite>, '+unixToHumanReadable(value.date)+'</footer></blockquote>');
                });

                $("#resultsCntr").slideDown();
            }
        });
    });
};