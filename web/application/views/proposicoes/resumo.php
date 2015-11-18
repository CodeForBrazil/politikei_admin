<?php $this->load->view('header'); ?>
<div class="container" role="main">
    <div class="row">
        <form method="post" class="form-horizontal" role="form">
            <div class="col-sm-6 col-md-6 col-lg-6 table-responsive">
                <div class="form-group">
                        <?= $this->load->view('widgets/proposicao', ['proposicao' => $proposicao], true); ?>
                </div>
                <div class="form-group">
                    <div class="controls">
                         <a href="<?= site_url('/proposicoes') ?>" class="btn btn-default">
                            Voltar
                        </a>

                        <a href="<?= $proposicao->link ?>" target="_blank" class="btn btn-default btn-sm" data-toggle="tooltip" title="Acessar Inteiro Teor">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Acessar Inteiro Teor
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 table-responsive">
                <div class="form-group">
                <?php if($proposicao->pode_reservar($errors)): ?>
                    <p>Proposição  ainda não reservada</p>
                    <a href="<?= site_url('/proposicoes/reservar/'.$proposicao->id) ?>" class="btn btn-default btn-sm post-link" data-confirm="Confirma que deseja reservar esta proposição?">
                        Reservar para resumo
                    </a>
                <?php endif; ?> 
                <?php if($proposicao->is_reservada()): ?>
                    <p>Proposição reservada por: <?= $proposicao->get_colaborador()->get_name_or_email() ?></p>
                    <?php if($proposicao->pode_liberar($current_user, $errors)): ?>
                    <a href="<?= site_url('/proposicoes/liberar/'.$proposicao->id) ?>" class="btn btn-default btn-sm post-link" data-confirm="Confirma que deseja liberar esta proposição?">
                        Liberar reserva de resumo
                    </a>
                    <?php endif; ?>
                <?php endif; ?>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="descricao">
                        Descrição
                    </label>
                    <div class="controls col-sm-10">
                        <input id="descricao" <?= $proposicao->pode_editar_resumo($current_user, $errors) ? "" : "disabled" ?>  name="descricao" type="text" class="input form-control" value="<?= $proposicao->descricao ?>" maxlength="255" />
                        <div class="alert-danger">
                            <?= form_error('descricao'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="resumo">
                        Resumo
                    </label>
                    <div class="controls col-sm-10">
                        <textarea <?= $proposicao->pode_editar_resumo($current_user, $errors) ? "" : "disabled" ?> rows="20" name="resumo" id="resumo" class="form-control"><?= $proposicao->resumo ?></textarea>
                        <div class="alert-danger">
                            <?= form_error('resumo'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls col-sm-6 col-sm-offset-2">
                        <?php if($proposicao->pode_editar_resumo($current_user, $errors)): ?>
                        <button type="submit" class="btn btn-primary">
                            Salvar resumo
                        </button>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<?php $this->load->view('footer.php');
