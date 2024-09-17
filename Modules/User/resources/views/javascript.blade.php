<script type="text/javascript">
    $(document).ready(function () {
        selectRole();
        init_table();
    })

    function selectRole(){
        $.ajax({
            url: '{{ route('user.role_list') }}',
            type: 'POST',
            headers:{
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response){
                SUPER.setDataMultipleCombo([{
                    data: response.roles,
                    el: 'role_id',
                    valueField: 'role_id',
                    displayField: 'role_name',
                    select2: true,
                    placeholder: 'Pilih Role'
                }]);
            }
        });
    }

    function init_table() {
        if ($.fn.DataTable.isDataTable('#tableUser')) {
			$('#tableUser').DataTable().destroy();
		}
        let roles = (SUPER.get_role_access('userupdate') || SUPER.get_role_access('userdelete'));
        table = $('#tableUser').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            pageLength: 10,
            // select: 'single',
            ajax: {
                url: '{{ route('user.init_table') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {
                    d.search.value = $('#tableUser_filter input').val();
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 419 || xhr.status === 401) {
                        SUPER.showMessage({
                            success: false,
                            message: 'Sesi telah berakhir',
                            title: 'Gagal'
                        });
                        setLogout();
                    } else {
                        // Handle other error cases
                        // For example, you can display an error message to the user
                        console.error(error);
                    }
                }
            },
            columns: [
                {
                    data: 'no',
                    name: 'no',
                    orderable: true,
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                },
                {
                    data: 'role_name',
                    name: 'role_name',
                    orderable: true,
                },
                {
                    data: null,
                    orderable: false,
                    visible: true,
                    render: function (data, type, full, meta) {
                        var btn_aksi = '';

                        // if(SUPER.get_role_access('userupdate')){
                        //     btn_aksi += `<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md mr-2" title="Edit" onclick="onEdit(this)" data-id="` + full.id + `">
                        //         <i class="la la-edit"></i> Edit
                        //     </a>`;
                        // }

                        // if(SUPER.get_role_access('userdelete')){
                        //     btn_aksi += `<a href="javascript:;" class="btn ml-3 btn-sm btn-clean btn-icon btn-icon-md kt-font-bold kt-font-danger" onclick="onDestroy(this)" data-id="` + full.id + `" title="Hapus" >
                        //         <span class="la la-trash"></span> Hapus
                        //     </a>`;
                        // }

                        btn_aksi += `<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md mr-2" title="Edit" onclick="onEdit(this)" data-id="` + data.usrid + `">
                            <i class="la la-edit"></i> Edit
                        </a>`;

                        btn_aksi += `<a href="javascript:;" class="btn ml-5 btn-sm btn-clean btn-icon btn-icon-md kt-font-bold kt-font-danger" style="margin-left: 15px" onclick="onDestroy(this)" data-id="` + data.usrid + `" title="Hapus" >
                            <span class="la la-trash"></span> Hapus
                        </a>`;

                        return btn_aksi;
                    }
                }
            ],
            fnDrawCallback: function(oSettings) {
                var cnt = 0;
                $("tr", this).css('cursor', 'pointer');
                $("tbody tr", this).each(function(i, v) {
                    $(v).on('click', function() {
                        if ($(this).hasClass('selected')) {
                            --cnt;
                            $(v).removeClass('selected');
                            $(v).removeAttr('checked');
                            $('input[name=checkbox]', v).prop('checked', false);
                            $(v).removeClass('row_selected');
                        } else {
                            ++cnt;
                            $('input[name=checkbox]', v).prop('checked', true);
                            $('input[name=checkbox]', v).data('checked', 'aja');
                            $(v).addClass('selected');
                            $(v).addClass('row_selected asli');
                        }

                        if (cnt > 0) {
                            $('.disable').attr('disabled', false);
                        } else {
                            $('.disable').attr('disabled', true);
                        }
                    });
                });
            },
        });
    }

    function onDestroy(element){
        var id = $(element).data('id');
        SUPER.confirm({
			message: "Apa Anda yakin ingin menghapus data ini?",
			callback: (result) => {
				if (result) {
                    $.ajax({
                        url: '{{ route('user.delete') }}',
                        type: 'DELETE',
                        headers:{
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if(response.success) {
                                SUPER.showMessage({
                                    success: true,
                                    message: 'Berhasil melakukan penghapusan data',
                                    title: 'Berhasil'
                                });
                            }else{
                                SUPER.showMessage();
                            }
                            init_table();
                        }
                    });
                }
			}
		});
    }

    function onSave(form){
        SUPER.saveForm({
            element: form,
            checker: 'id',
            add_route: '{{ route('user.create') }}',
            update_route: '{{ route('user.update') }}',
            onBack: false,
            reInitTable: true,
        });
    }

    function onEdit(element){
        blockPage();
        var id_usr = element.getAttribute('data-id');
        $.ajax({
            url: "{{ route('user.read') }}",
            type: 'POST',
            data:{
                id: id_usr,
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(res){
                $.each(res.data, function(key, value) {
                    $('#'+key).val(value).trigger('change');
                });
                $("#role_id").select2("trigger", "select", {
					data: {
						id: res.data.role_id,
						text: res.data.role_name
					}
				});
                var imglink = '{{ asset('uploads/users/origins/') }}/' + res.data.img;
                $('#kt_image_input_profile').attr('style', 'background-image: url('+imglink+')');
                $('#photoPreview').attr('style', 'background-image: url('+imglink+')');
                $('#password').val('').trigger('change');
                $('#id').val(res.data.usrid).trigger('change');
            },
            error: function(xhr, status, error) {
                SUPER.showMessage();
                console.log(error);
            }
        });
        unblockPage();
    }
</script>
