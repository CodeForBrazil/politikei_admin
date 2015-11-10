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
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 table-responsive" id="disabled_objects">
            <form method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="descricao">
                        Descrição
                    </label>
                    <div class="controls col-sm-8">
                        <input id="descricao" name="descricao" type="text" class="input form-control" value="<?= $proposicao->descricao ?>" maxlength="255" />
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
                        <textarea rows="20" name="resumo" id="resumo" class="form-control"><?= $proposicao->resumo ?></textarea>
                        <div class="alert-danger">
                            <?= form_error('resumo'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls col-sm-6 col-sm-offset-2">
                        <button type="submit" class="btn btn-danger">
                            Salvar
                        </button>
                        <a href="<?= site_url('/proposicoes') ?>" class="btn btn-default">
                            Voltar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('footer.php');
