<?php $this->load->view('header'); ?>
<div class="container" role="main">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 table-responsive" id="disabled_objects">
            <h3><?php echo $proposicao->nome ."\n"; ?></h3>
            <p>
                <?php echo $proposicao->ementa ."\n"; ?>
            </p>
            
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 table-responsive">
            <form method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="descricao">
                        Descrição
                    </label>
                    <div class="controls col-sm-8">
                        <input id="descricao" <?= $proposicao->pode_editar_resumo($user, $errors) ? "" : "disabled" ?>  name="descricao" type="text" class="input form-control" value="<?= $proposicao->descricao ?>" maxlength="255" />
                        <div class="alert-danger">
                            <?= form_error('descricao'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="resumo">
                        Resumo
                    </label>
                    <div class="controls col-sm-8">
                        <textarea <?= $proposicao->pode_editar_resumo($user, $errors) ? "" : "disabled" ?> rows="20" name="resumo" id="resumo" class="form-control"><?= $proposicao->resumo ?></textarea>
                        <div class="alert-danger">
                            <?= form_error('resumo'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls col-sm-6 col-sm-offset-2">
                        <?php if($proposicao->pode_editar_resumo($user, $errors)): ?>
                        <button type="submit" class="btn btn-primary">
                            Salvar resumo
                        </button>
                        <?php endif; ?>
                        <a href="<?= site_url('/proposicoes') ?>" class="btn btn-default">
                            Voltar
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls col-sm-6 col-sm-offset-2">
                        <?php if($proposicao->is_reservada()): ?>
                            <p>Proposição reservada por: <?= $proposicao->get_colaborador()->get_name_or_email() ?></p>
                        <?php endif; ?>  
                        <?php if($proposicao->pode_publicar($user, $errors)): ?>
                        <a href="<?= site_url('/proposicoes/publicar/'.$proposicao->id) ?>" class="btn btn-success post-link" data-confirm="Confirma publicação desta proposição?">
                            Publicar proposição
                        </a>
                        <?php endif; ?>
                        <?php if($proposicao->pode_liberar($user, $errors)): ?>
                        <a href="<?= site_url('/proposicoes/liberar/'.$proposicao->id) ?>" class="btn btn-default post-link" data-confirm="Confirma que deseja liberar esta proposição?">
                            Liberar reserva de resumo
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 table-responsive">
            <div class="form-group">
                <div class="controls col-sm-6 col-sm-offset-2">

                </div>
            </div>
        </div>
    </div>

</div>
<?php $this->load->view('footer.php');
