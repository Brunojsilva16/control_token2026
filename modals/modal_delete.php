<!-- Delete -->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true"role="dialog">
<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="deleteForm" class="form-horizontal" >
                <div class="modal-body">
                    <div class="text-textcenter">
                        <p>Tem certeza de que deseja excluir?</p>
                        <h2 class="bold fullname"></h2>
                    </div>
                </div>

                <div class="carregando" style="color:green"></div>
                <div class="resultadoLoading" style="color: red;"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
                    <button type="submit" class="btn btn-danger btn-flat" id="idpac" name="iddel"><i class="fa fa-trash" aria-hidden="true"></i>
                        Delete</button>
                    <input type="hidden" class="form-control form-control-sm idpage" name="idpag">
                </div>
            </form>

        </div>
    </div>
</div>