<label class="form-label">Category</label>
@foreach(category_list() as $category)
    <ul class="category-tree">
        <li class="list-style-none">
            <input 
                type="radio"
                name="category_id" 
                value="{{$category->id}}" 
                class="form-check-input"
                {{ $data == $category->id ? 'checked' : '' }}
            >
            {{$category->name}}
        </li>
        @if(count($category->ancestors))
            @include('admin.category.tree.child',[
                'child' => $category->ancestors
            ])
        @endif
    </ul>
@endforeach