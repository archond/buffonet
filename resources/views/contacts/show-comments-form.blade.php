<style>
    .error {
        border-color: red;
    }
</style>


{!! Form::open(['route'=>['contacts.store-comment', $contact->id], 'method'=>'post' ]) !!}
{!! Form::textarea('comment', null, ['id'=>'comment', 'class'=> ($errors->first('comment') ) ? 'error form-control' : 'form-control', 'placeholder'=>_('Input comment here') ]) !!}
{!! Form::button(_('Add comment'), ['class'=>'btn btn-info pull-right', 'type'=>'submit']) !!}
{!! Form::close() !!}

<script>
    $(document).ready(function () {
        $('#comment').click(function () {
            $(this).removeClass('error');
        });
    });
</script>