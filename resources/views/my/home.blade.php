<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AJAX</title>

    <!--JQuery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!--DataTables-->
    <link rel="stylesheet" href="{{asset("DataTables/datatables.min.css")}}">
    <script src="{{asset("DataTables/datatables.min.js")}}"></script>

    <style>
        .modal{
            display: none;
            position: fixed;
            z-index: 4;
            left:0;
            top:0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content{
            margin: 7% auto;
            width: 50%;
            color: #2d3748;
        }

        .close{
            color: #ee2323;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover{
            color: #aa1f1f;
            cursor: pointer;
        }

        .delete{
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #4a5568;
        }

        .deletebuttons{
            width: 6rem;
            height: 2.5rem;
        }

    </style>
</head>
<body class="h-100 " style="background-color: #344955;color: white">

    <div class="container h-100 d-flex flex-column align-items-center" style="padding-top: 4%">
        <!--Table Task Start-->
        <div class="row w-100 mb-4 mt-auto g-0 justify-content-center">
            <div class="col-11 d-flex flex-column align-items-center">
                <!--Header-->
                <div class="row w-100 mb-1 g-0">
                    <div class="col d-flex justify-content-between align-items-center">
                        <h2>Görevler</h2>
                        <button id="add_task" class="btn btn-success h-85 d-flex align-items-center">Ekle</button>
                    </div>
                </div>

                <!--Table-->
                <div class="row w-100 mb-5 g-0">
                    <div class="col">
                        <table id="myTable" class="display table table-dark table-bordered">
                            <thead>
                                <tr>
                                    <th>Görev Açıklaması</th>
                                    <th>Kategorisi</th>
                                </tr>
                            </thead>

                            <tbody class="table-light" id="table_task_body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--Table Task End-->

        <!--Task Create Modal Box-->
        <div id="modal_task" class="modal">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="container m-0">
                    <div class="row flex-column align-items-center" style="margin-bottom: 20%">
                        <div class="col-11 col-lg-8">
                            <div class="modal-content card m-0 p-0 w-100">
                                <div class="card-header d-flex align-items-center justify-content-between" style="height: 20%">
                                    <h3 class="ps-2 mb-0">Görev Ekle</h3>
                                    <span id="close_task" class="pe-2 pb-1 close">&times;</span>
                                </div>
                                <div class="card-body p-4">
                                    <div>
                                        <form>
                                            @csrf
                                            <div class="mb-3">
                                                <label for="task_text" class="form-label">Görev</label>
                                                <input type="text" class="form-control" id="task_text">
                                            </div>
                                            <div class="mb-3" style="width: fit-content">
                                                <label for="task_select" class="form-label">Kategori</label>
                                                <select id="task_select" class="form-select">
                                                    <option selected disabled>Lütfen bir kategori seçiniz</option>
                                                </select>
                                            </div>
                                            <button type="button" id="send_task" class="btn btn-success mt-3 float-end">Ekle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Task Update Modal Box-->
        <div id="modal_task_update" class="modal">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="container m-0">
                    <div class="row flex-column align-items-center" style="margin-bottom: 20%">
                        <div class="col-11 col-lg-8">
                            <div class="modal-content card m-0 p-0 w-100">
                                <div class="card-header d-flex align-items-center justify-content-between" style="height: 20%">
                                    <h3 class="ps-2 mb-0">Görev Güncelle</h3>
                                    <span id="close_task_update" class="pe-2 pb-1 close">&times;</span>
                                </div>

                                <div class="card-body p-4">
                                    <div>
                                        <form>
                                            <div class="mb-3">
                                                <label for="task_update_text2" class="form-label">Yeni Görev</label>
                                                <input type="text" class="form-control" id="task_update_text2">
                                            </div>
                                            <div class="mb-3" style="width: fit-content">
                                                <label for="task_category_update_select" class="form-label">Yeni Kategori</label>
                                                <select id="task_category_update_select" class="form-select">
                                                    <option selected disabled>Lütfen bir kategori seçiniz</option>
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-success mt-3 float-end" id="update_task_button">Güncelle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Task Delete Modal Box-->
        <div id="modal_task_delete" class="modal">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="container m-0">
                    <div class="row flex-column align-items-center" style="margin-bottom: 20%">
                        <div class="col-11 col-sm-8 col-lg-6 col-xl-4">
                            <div class="modal-content card m-0 p-0 w-100">
                                <div class="card-body p-4 d-flex justify-content-center align-items-center">
                                    <div>
                                        <p class="delete">Görevi silmek istediğinize emin misiniz?</p>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-danger me-3 deletebuttons" id="delete_task_button">Sil</button>
                                            <button type="submit" class="btn btn-primary me-3 deletebuttons" id="close_task_delete">İptal Et</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Category Create Modal Box-->
        <div id="modal_category" class="modal">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="container m-0">
                    <div class="row flex-column align-items-center" style="margin-bottom: 20%">
                        <div class="col-11 col-lg-8">
                            <div class="modal-content card m-0 p-0 w-100">
                                <div class="card-header d-flex align-items-center justify-content-between" style="height: 20%">
                                    <h3 class="ps-2 mb-0">Kategori Ekle</h3>
                                    <span id="close_category" class="pe-2 pb-1 close">&times;</span>
                                </div>
                                <div class="card-body p-4">
                                    <div>
                                        <form>
                                            <div class="mb-3">
                                                <label for="category_text" class="form-label">Kategori</label>
                                                <input type="text" class="form-control" id="category_text">
                                            </div>
                                            <button type="button" id="send_category" class="btn btn-success mt-3 float-end">Ekle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Category Update Modal Box-->
        <div id="modal_category_update" class="modal">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="container m-0">
                    <div class="row flex-column align-items-center" style="margin-bottom: 20%">
                        <div class="col-11 col-lg-8">
                            <div class="modal-content card m-0 p-0 w-100">
                                <div class="card-header d-flex align-items-center justify-content-between" style="height: 20%">
                                    <h3 class="ps-2 mb-0">Kategori Güncelle</h3>
                                    <span id="close_category_update" class="pe-2 pb-1 close">&times;</span>
                                </div>
                                <div class="card-body p-4">
                                    <div>
                                        <form>
                                            <div class="mb-3">
                                                <label for="category_text_update2" class="form-label">Yeni Kategori</label>
                                                <input type="text" class="form-control" id="category_text_update2">
                                            </div>

                                            <button type="button" class="btn btn-success mt-3 float-end" id="update_category_button">Güncelle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Category Delete Modal Box-->
        <div id="modal_category_delete" class="modal">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="container m-0">
                    <div class="row flex-column align-items-center" style="margin-bottom: 20%">
                        <div class="col-11 col-sm-8 col-lg-6 col-xl-4">
                            <div class="modal-content card m-0 p-0 w-100">
                                <div class="card-body p-4 d-flex justify-content-center align-items-center">
                                    <div>
                                        <p class="delete">Kategoriyi silmek istediğinize emin misiniz?</p>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-danger me-3 deletebuttons" id="delete_category_button">Sil</button>
                                            <button type="button" class="btn btn-primary me-3 deletebuttons" id="close_category_delete">İptal Et</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--Table Category Start-->
        <div class="row w-100 mb-auto g-0 justify-content-center" style="padding-bottom: 6%">
            <div class="col-11 col-lg-11 d-flex flex-column align-items-center">
                <!--Header-->
                <div class="row w-100 mb-1 g-0">
                    <div class="col d-flex justify-content-between align-items-center">
                        <h2>Kategoriler</h2>
                        <button id="add_category" class="btn btn-success h-85 d-flex align-items-center">Ekle</button>
                    </div>
                </div>

                <!--Table-->
                <div class="row w-100 g-0">
                    <div class="col">
                        <table id="myTable2" class="display table table-dark table-bordered">
                            <thead>
                                <tr>
                                    <th>Kategori Adı</th>
                                </tr>
                            </thead>

                            <tbody class="table-light">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--Table Category End-->
    </div>

    <script>

        function createDataTable(table,button_update_id,button_delete_id,target_number,route_name,column_array){
            $(table).DataTable({
                ajax: route_name,
                columns:column_array,
                rowId: "id",
                scrollX:true,
                columnDefs: [
                    {
                        data: null,
                        defaultContent:
                            '<button class="btn btn-primary shadow me-2" id="'+button_update_id+'" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">Güncelle</button>' +
                            '<button class="btn btn-danger" id="'+button_delete_id+'" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">Sil</button>',
                        targets: target_number,
                        orderable:false,
                        width:'15%',
                        createdCell: function (td) {
                            $(td).addClass('d-flex justify-content-center');
                        }
                    }
                ]
            });
        }

        //Table Task
        createDataTable('#myTable',"update_task","delete_task",2,"/taskGet",[{data:"description"}, {data:"category_id"}]);

        //Table Category
        createDataTable('#myTable2',"update_category","delete_category",1,"/categoryGet",[{data:"name"}]);

        function actionsOnModalBoxes(button_id,modal_box_id,action){
            $(button_id).click(function (){
                $(modal_box_id).css("display",action);
            });
        }

        function actionsOnModalBoxes2(table,button_id,modal_box_id){
            $(table).on("click",button_id ,function (event){
                $(modal_box_id).css("display","block");

                var datatable = new DataTable(table);
                let data = datatable.row(event.target.closest('tr')).data();
                let id_row = datatable.row(event.target.closest('tr')).id();

                if(button_id === "#update_task"){
                    $("#task_update_text2").val(data.description);
                    const select = document.getElementById("task_category_update_select");
                    select.value = data.get_category.id;
                    $("#update_task_button").off("click").on("click",(function (){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type:'post',
                            url: "taskUpdate",
                            data: {id:id_row,text:$("#task_update_text2").val(),category:$("#task_category_update_select").val()},
                            success: function (){
                                alert("Başarılı!")
                                $("#modal_task_update").css("display","none");
                                reloadTableData("#myTable")

                            },
                            error:function (){
                                alert("Hata!");
                            }
                        })
                    }));
                }
                else if(button_id === "#update_category"){
                    $("#category_text_update2").val(data.name);

                    $("#update_category_button").off("click").on("click",(function (){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type:'post',
                            url: "categoryUpdate",
                            data: {id:id_row,name:$("#category_text_update2").val()},
                            success: function (){
                                alert("Başarılı!");
                                $("#modal_category_update").css("display","none");
                                reloadTableData("#myTable2");
                            },
                            error: function (){
                                alert("Hata!");
                            }
                        })
                    }));
                }
                else if(button_id === "#delete_task"){
                    $("#delete_task_button").click(function (){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"taskDelete",
                            type:"DELETE",
                            data: {id:id_row},
                            success:function (){
                                alert("Başarılı!")
                                $("#modal_task_delete").css("display","none");
                                reloadTableData("#myTable")
                            },
                            error:function (){
                                alert("Hata!");
                            }
                        })
                    });

                }
                else if(button_id === "#delete_category"){
                    $("#delete_category_button").click(function (){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"/categoryDelete",
                            type:"DELETE",
                            data:{id:id_row},
                            success:function (){
                                alert("Başarılı!");
                                $("#modal_category_delete").css("display","none");
                                reloadTableData("#myTable")
                                reloadTableData("#myTable2")
                                reloadSelectOptions();
                            },
                            error:function (){
                                alert("Hata!");
                            }
                        })
                    });
                }

            });
        }

        //Show Modal Box
        actionsOnModalBoxes("#add_task","#modal_task","block");
        actionsOnModalBoxes("#add_category","#modal_category","block")

        //Close Modal Box
        //Task Table
        actionsOnModalBoxes("#close_task","#modal_task","none");
        actionsOnModalBoxes("#close_task_update","#modal_task_update","none");
        actionsOnModalBoxes("#close_task_delete","#modal_task_delete","none");
        actionsOnModalBoxes2("#myTable","#update_task","#modal_task_update");
        actionsOnModalBoxes2("#myTable","#delete_task","#modal_task_delete",);
        //Category Table
        actionsOnModalBoxes("#close_category","#modal_category","none");
        actionsOnModalBoxes("#close_category_update","#modal_category_update","none");
        actionsOnModalBoxes("#close_category_delete","#modal_category_delete","none");
        actionsOnModalBoxes2("#myTable2","#update_category","#modal_category_update");
        actionsOnModalBoxes2("#myTable2","#delete_category","#modal_category_delete");

        $(window).click(function (event){
            if($(event.target).is(".modal")){
                $(".modal").css("display","none");
            }
        })

        loadCategoryOptionsData();

        function postData(dataArray,route_name,callback){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url: route_name,
                data: dataArray,
                success: callback,
                error:function (){
                    alert("Hata!");
                }
            })
        }

        function loadCategoryOptionsData(){
            $.ajax({
                type:'get',
                url: 'categoryGet',
                success: function (data){
                    $.each(data.data,function (index,item){
                        const select = document.getElementById("task_category_update_select");
                        const select2 = document.getElementById("task_select");
                        let opt = document.createElement('option');
                        let opt1 = document.createElement('option');
                        opt.value = item.id;
                        opt.innerHTML = item.name;
                        opt1.value = item.id;
                        opt1.innerHTML = item.name;
                        select.add(opt);
                        select2.add(opt1);
                    })
                },
                error:function (){
                    alert("Hata!");
                }
            })
        }

        function reloadTableData(table){
            const datatable = new DataTable(table);
            datatable.ajax.reload();
        }

        function reloadSelectOptions(){
            $("#task_category_update_select option:not(:first)").remove();
            $("#task_select option:not(:first)").remove();
            loadCategoryOptionsData();
        }


        $("#send_task").click(function (){
            let dataArray = {task_text:$("#task_text").val(),task_category:$("#task_select").val()};
            let route_name = "/taskPost"
            postData(dataArray,route_name,function (){
                alert("Başarılı!")
                $("#modal_task").css("display","none");
                reloadTableData("#myTable");
            });

        });

        $("#send_category").click(function (){
            let dataArray = {category_text:$("#category_text").val()};
            let route_name = "/categoryPost"
            postData(dataArray,route_name,function (){
                alert("Başarılı!")
                $("#modal_category").css("display","none");
                reloadTableData("#myTable2");
                reloadSelectOptions();
            });

        });




    </script>
</body>

</html>
