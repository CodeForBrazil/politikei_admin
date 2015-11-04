<?php $this->load->view('header'); ?>
<div class="container" role="main">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 table-responsive" id="disabled_objects">
            <form method="get" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="sigla">
                        Sigla
                    </label>
                    <div class="controls col-sm-6">
                        <input id="sigla" name="sigla" type="text" class="input form-control" value="<?= $sigla ?>" maxlength="100" />
                        <div class="alert-danger">
                            <?= form_error('sigla'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="ano">
                        Ano
                    </label>
                    <div class="controls col-sm-6">
                        <input id="ano" name="ano" type="text" class="input form-control" value="<?= $ano ?>" maxlength="100" />
                        <div class="alert-danger">
                            <?= form_error('ano'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="numero">
                        Número
                    </label>
                    <div class="controls col-sm-6">
                        <input id="numero" name="numero" type="text" class="input form-control" value="<?= $numero ?>" maxlength="100" />
                        <div class="alert-danger">
                            <?= form_error('numero'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls col-sm-6 col-sm-offset-4">
                        <button type="submit" class="btn btn-danger">
                            Pesquisar
                        </button>
                        <a href="<?= site_url('/proposicoes') ?>" class="btn btn-default">
                            Voltar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <ul>
            <?php foreach ($proposicoes as $proposicao) : ?>
            <li>
                <h3><?php echo $proposicao->nome ."\n"; ?></h3>
            	<a href="<?= site_url('/proposicoes/adicionar/'.$proposicao->camara_id.'?sigla='.$sigla.'&ano='.$ano.'&numero='.$numero) ?>" class="btn btn-info post-link" data-confirm="Confirma a inclusão desta proposição">Adicionar</a>
                <p>
                    <?php echo $proposicao->descricao ."\n"; ?>
                </p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php $this->load->view('footer.php');
