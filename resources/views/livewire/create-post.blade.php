<div>
    <menus class="grid grid-cols-1 border-b-2 ">


        <x-menus.menu-middle />


    </menus>
    <div>
        <div>
          @if (session()->has('message') && $showAlert = true)
          <x-forms.success />
          @endif
        </div>
      </div>
      
        <div class="px-2">
        <!-- This Section allows adding and update forms -->
            @include('livewire.posts.create')
    
            @auth
                @if($form->post_id)
                    <livewire:images.upload :post="$form->post" />
                @endif
            @endauth
        </div>
    </div>
</div>
