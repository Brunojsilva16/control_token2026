  <!-- Activate -->
  <div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="activate" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="activate">Activação...</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="sqls/ativa_adm.php">
           <input type="hidden" name="id_u" id="u_ativo">
           <input type="hidden" name="tipo_u" id="s_ativo">
           <div class="text-center">
            <p>ATIVAR CONTA DE PROFISSIONAL?</p>
            <h2 class="bold fullname"></h2>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
          <button type="submit" class="btn btn-success btn-flat" name="activate"><i class="fa fa-check"></i> Ativar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- desactivate -->
<div class="modal fade" id="desactivate" tabindex="-1" role="dialog" aria-labelledby="desactivate" aria-hidden="true">
  <div class="modal-dialog modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="desactivate">Desactivação...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="sqls/ativa_adm.php">
          <input type="hidden" name="id_u" id="u_desativo">
          <input type="hidden" name="tipo_u" id="s_desativo">
          <div class="text-center">
            <p>DESATIVAR CONTA DE PROFISSIONAL?</p>
            <h2 class="bold fullname"></h2>
          </div>
        </div>

        <div class="modal-footer">
         <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
         <button type="submit" class="btn btn-danger btn-flat" name="desactivate"><i class="fa fa-check"></i> Desativar</button>
       </div>
     </form>
   </div>
 </div>
</div>