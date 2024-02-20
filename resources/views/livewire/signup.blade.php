<div class="bg-white rounded-xl shadow p-8 flex flex-col gap-6 min-w-[35rem]">
    <div>
        <h2 class="text-3xl font-bold mb-1">Let's start your journey!</h2>
        <span class="text-lg pb-2 text-slate-600">Sign up for a new account</span>
    </div>

    <hr class="w-[75%]">

    <label class="flex flex-col gap-2">
        Email
        <input type="password" class="px-3 py-2 border border-slate-300 rounded-lg">
    </label>

    <label class="flex flex-col gap-2">
        Password
        <input type="password" class="px-3 py-2 border border-slate-300 rounded-lg">
    </label>

    <label class="flex flex-col gap-2">
        Confirm password
        <input type="password" class="px-3 py-2 border border-slate-300 rounded-lg">
    </label>

    <button wire:click="openModal">Open modal from livewire</button>

    <div class="flex justify-between items-center pt-4">
        <div class="flex justify-start items-center gap-2 text-sm">
            <input type="checkbox" class="border">

            <span>I agree to the</span>

            <x-modal wire:model.live="showModal">
                <x-modal.panel>

                    <div class="mt-5 text-gray-600">
                       <h3 class="font-bold text-lg text-slate-800 mt-4">Acceptance of Terms</h3>
                       <p class="mt-2">By signing up for and using this sweet app, you agree to be bound by these Terms of Service ("Terms"). If you do not agree with these Terms, please do not use the Service.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">Changes to Terms</h3>
                       <p class="mt-2">We reserve the right to update and change the Terms at any time without notice. Continued use of the Service after any changes shall constitute your consent to such changes.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">Use of the Service</h3>
                       <p class="mt-2">You must provide accurate and complete registration information when you sign up. You are responsible for maintaining the confidentiality of your password and are solely responsible for all activities resulting from its use.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">User Content</h3>
                       <p class="mt-2">You are responsible for all content and data you provide or upload to the Service. We reserve the right to remove content deemed offensive, illegal, or in violation of these Terms or any other policy.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">Limitation of Liability</h3>
                       <p class="mt-2">The Service is provided "as is". We make no warranties, expressed or implied, and hereby disclaim all warranties, including without limitation, implied warranties of merchantability, fitness for a particular purpose, or non-infringement.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">Termination</h3>
                       <p class="mt-2">We reserve the right to suspend or terminate your account at any time for any reason, with or without notice.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">Governing Law</h3>
                       <p class="mt-2">These Terms shall be governed by the laws of the land of fairy tale creatures, without respect to its conflict of laws principles.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">Miscellaneous</h3>
                       <p class="mt-2">If any provision of these Terms is deemed invalid or unenforceable, the remaining provisions shall remain in effect.</p>

                       <h3 class="font-bold text-lg text-slate-800 mt-4">Contact</h3>
                       <p class="mt-2">For any questions regarding these Terms, please contact us at dontcontactus@ever.com.</p>
                    </div>
                </x-modal.panel>
            </x-modal>
        </div>

        <button class="w-1/2 text-center rounded-xl bg-blue-500 text-white px-3 py-2 font-medium">Register</button>
    </div>
</div>