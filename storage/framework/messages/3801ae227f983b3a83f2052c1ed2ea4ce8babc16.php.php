<style>
    .error {
        border-color: red;
    }
</style>


<?php echo Form::open(['route'=>['contacts.store-comment', $contact->id], 'method'=>'post' ]); ?>

<?php echo Form::textarea('comment', null, ['id'=>'comment', 'class'=> ($errors->first('comment') ) ? 'error form-control' : 'form-control', 'placeholder'=>_('Input comment here') ]); ?>

<?php echo Form::button(_('Add comment'), ['class'=>'btn btn-info pull-right', 'type'=>'submit']); ?>

<?php echo Form::close(); ?>


<script>
    $(document).ready(function () {
        $('#comment').click(function () {
            $(this).removeClass('error');
        });
    });
</script>