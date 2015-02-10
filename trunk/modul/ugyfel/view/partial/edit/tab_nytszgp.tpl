<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <label>{$client->getAttributeLabel('vegzettseg_id')}</label>
        {html_options 
            name="client[vegzettseg_id]" 
            options=$highestDegreeOptions 
            selected=$client->vegzettseg_id}
        {ar_error model=$client property='vegzettseg_id' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Tanulmányok</label>
        {include file="modul/ugyfel/view/partial/edit/sheep_it_education.tpl"}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Nyelvtudás</label>
        {include file="modul/ugyfel/view/partial/edit/sheep_it_knowledge.tpl"}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Számítógépes ismeret</label>
        {include file="modul/ugyfel/view/partial/edit/sheep_it_computer_knowledge.tpl"}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea 
            name="models[comment_education][megjegyzes]" 
            class="uw-ugyfelkezelo-input-textarea-megjegyzes"
        >{if $CommentEducation}{$CommentEducation->megjegyzes}{/if}</textarea>
        {ar_error model=$CommentEducation property='megjegyzes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.uw-ugyfelkezelo-form-->