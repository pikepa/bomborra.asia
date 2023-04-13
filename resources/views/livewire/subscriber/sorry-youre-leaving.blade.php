<div>
    
<x-guest-layout>
    <x-pages.standard-page>
            <div onclick="location.href='/';" class="cursor-pointer">
                <menus class="grid grid-cols-1 border-b-2 ">

                    <Livewire:menus.menu-top />
    
                    <x-menus.menu-middle />
    
                    <Livewire:menu-bottom />
                </menus>
            </div>
         <div >
            <div >
                <x-forms.card title="We're sorry to see you go.">

                    <p class="text-center mt-2 text-2xl font-semibold">
                        Your email and name have been deleted.
                    </p>
                    <p class="text-center mt-2 text-xs">
                        (Click on banner to return to front Page)
                    </p>
                </x-forms.card>
            </div>

        </div>


    </x-pages.standard-page>
</x-guest-layout>
</div>
