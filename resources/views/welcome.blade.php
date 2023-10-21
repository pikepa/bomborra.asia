<x-app-layout>
    <x-pages.standard-page>
        <div class="max-w-7xl min-h-screen mx-auto">
            <div class=" text-5xl text-center p-8 rounded-lg border-b-2 text-gray-100 bg-teal-800 font-bold">
                {{$post->title}}
            </div>
            <div class="mx-auto">
                <x-pages.subscribe-and-enter />
            </div>
            <div class="min-h-full rounded-lg">
                <div class=" flex flex-col ">
                    <div class="p-4  ">
                        <div class="mx-auto sm:float-left sm:w-1/3 sm:mr-4 rounded-lg">
                            <img class="rounded-lg" src="{{$post->cover_image}}" alt="Cover Image">
                        </div>

                        <div class="mt-6 sm:mt-0  text-justify">
                            {!!$post->body!!}
                        </div>
                    </div>

                </div>
            </div>
            <!-- design details -->
            <div
                class="flex flex-col sm:flex-row justify-between border rounded-lg bg-slate-50 gap-4 mx-4 p-4 mt-8 text-sm mb-8">

                <div>
                    <div>{{config('constants.design')}}</div>
                    <div>{{config('constants.design_by')}}</div>
                </div>
                <div>
                    <div>Publisher: {{config('constants.publisher')}}</div>
                    <div>Contact: {{config('constants.publisher_contact')}}</div>
                </div>
                <div>
                    <div>Website by: {{config('constants.website')}}</div>
                    <div>Contact: {{config('constants.website_contact')}}</div>
                </div>
            </div>
        </div>
    </x-pages.standard-page>
</x-app-layout>