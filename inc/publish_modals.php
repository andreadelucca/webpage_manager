<!-- Modal Section -->
<div class="modal fade" id="modalVisualizePublish" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">Visualizar Publicação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="visualizeImageTitle">Título do Post</label>
                        <input type="text" name="txtVisualizeImageTitle" id="txtVisualizeImageTitle" class="form-control" disabled>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="visualizeImageSubtitle">Subtítulo do Post</label>
                        <textarea name="txtVisualizeImageSubtitle" id="txtVisualizeImageSubtitle" rows="5" class="form-control" style="resize: none;" disabled></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="visualizeImageFile">Imagem Publicada</label>
                        <div class="card">
                            <img class="card-img-top img-fluid" id="txtVisualizeImageFile" alt="imagem-bancodados">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar Visualização</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPublish" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">Editar Publicação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="message-error-success">

                </div>
                <form id="newuploadedit-form" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txtEditImageId" id="txtEditImageId" class="form-control">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editImageTitle">Título da Imagem *</label>
                            <input type="text" class="form-control" id="txtEditImageTitle" name="txtEditImageTitle">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="editImageSubtitle">Subtítulo da Imagem *</label>
                            <textarea name="txtEditImageSubtitle" id="txtEditImageSubtitle" rows="5" class="form-control" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editImageFile">Escolha um novo arquivo de foto (JPG, JPEG, TIFF) *</label>
                            <br>
                            <input type="file" name="txtEditImageFile" id="txtEditImageFile" accept="image/*">
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-success" id="buttonSubmitEditForm" onclick="saveGalleryEdit();">Salvar Dados</button>&nbsp;
                        <button type="button" class="btn btn-warning" id="buttonClearEditForm" onclick="resetFormulary();">Limpar Formulário</button>&nbsp;
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->