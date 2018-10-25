<div>{{-- šis DIVs ir obligāts jquery elementu klonešanai--}}
    <div class="form-group">
        {!! Form::label('parent_id', _('Category'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <?

            if ($categoryArrayTree[0]['showCurrentCategoryAsSelected'])
            {
                $level = 0;
            } else
            {
                $level = 2;
            }
            ?>
            {{--d($categoryArrayTree)--}}
            {{--dd($level)--}}
                <? $counter = 0 ?>
            @foreach(array_reverse($categoryArrayTree) as $key=> $tree)

                {{--
                    #level =0 - nav izvēleto kategoriju (rāda top kategorijas bez izvēlētas konkrētas lategorijas)
                    $level =1 - rāda savu kategoriju kā izvēlēto (pēdējo kategoriju)
                    $level =2 - rādā parentkategoriju kā izvēlēto, savas kategorijas izvēlni vispār nerāda
                --}}


                @if(isset($categoryArrayTree[($key+$level)]) )

                    @if(isset($tree['parent']) && count($tree['parent'])>0 )
                        <select class="myselect form-control" name="category_id">
                            <option value="0">-</option>

                            @foreach($tree['parent'] as $category)


                                <option value="{{$category['id']}}" @if($tree['parent_selected_id'] == $category['id'])  selected @endif >{{$category['translation']['name']}} </option>



                            @endforeach

                        </select>

                    @endif


                @elseif(count($categoryArrayTree) < 3 )

                    @if(isset($tree['parent']) && count($tree['parent'])>0  && $counter==0 )
                        <select class="myselect form-control" name="category_id">
                            <option value="0" selected="selected">-</option>


                            @foreach($tree['parent'] as $category)

                                <option value="{{$category['id']}}" @if($tree['parent_selected_id'] == $category['id'])  @endif >{{$category['translation']['name']}} </option>

                            @endforeach

                        </select>
                    @endif
                    <? $counter = $counter+1 ?>

                @endif



            @endforeach
        </div>
    </div>
</div>
@include('categories.includes.js')