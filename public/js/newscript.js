
$(document).ready(function(){

    //get base URL *********************
    var url = $('#url').val();

    //display modal form for creating new product *********************
    $('#btn_add').click(function(){
        $('#btn-save').val("add");
        $('#frmProducts').trigger("reset");
        $('#myModal').modal('show');
    });



    //create new product / update existing product ***************************
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();
        var formData = {
            zone_name: $('#zone_name').val(),

        }

        console.log(formData);

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var zone_id = $('#zone_id').val();;
        var my_url = url;
        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + zone_id;
        }
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var zone = '<tr id="zone' + data.id + '"><td>' + data.id + '</td><td>' + data.zone_name + '</td><td>';

                zone += '<td><button class="btn btn-warning btn-detail open_modal" value="' + data.id + '">Edit</button>';

                zone += ' <button class="btn btn-danger btn-delete delete-zone" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#products-list').append(zone);
                }else{ //if user updated an existing record
                    $("#zone" + zone_id).replaceWith( zone );
                }
                $('#frmProducts').trigger("reset");
                $('#myModal').modal('hide')
            },
            error: function (data) {
                /* $('#myModal').append(data.responseText);
                  console.log('Error:', data.responseText);*/
                console.log('Error:', data);

            }
        });
    });



});