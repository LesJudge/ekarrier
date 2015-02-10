<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <label>Közvetítések</label>
        {include file="modul/user/view/partial/ugyfel/edit/sheep_it_mediation.tpl"}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea 
            name="models[comment_activity][megjegyzes]" 
            class="uw-ugyfelkezelo-input-textarea-megjegyzes"
        >{if $CommentActivity}{$CommentActivity->megjegyzes}{/if}</textarea>
        {ar_error model=$CommentActivity property='megjegyzes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.uw-ugyfelkezelo-form-->