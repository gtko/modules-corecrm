<div class="col-span-12 md:col-span-6 xxl:col-span-12 mt-3 xxl:mt-6 p-4 box">
    <div class="intro-x flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 flex items-center">
            <svg class="h-5 w-5 mr-2"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 48H63.1C55.16 48 47.1 55.16 47.1 64V448C47.1 456.8 55.16 464 63.1 464H284.5C296.5 482.4 311.9 498.5 329.7 511.3C326.6 511.7 323.3 512 320 512H64C28.65 512 0 483.3 0 448V64C0 28.65 28.65 0 64 0H320C355.3 0 384 28.65 384 64V198.6C366.8 203.5 350.6 210.9 336 220.5V63.1C336 55.16 328.8 47.1 320 47.1L320 48zM95.1 152C95.1 138.7 106.7 128 119.1 128H263.1C277.3 128 287.1 138.7 287.1 152C287.1 165.3 277.3 176 263.1 176H119.1C106.7 176 95.1 165.3 95.1 152zM263.1 224C277.3 224 287.1 234.7 287.1 248C287.1 261.3 277.3 272 263.1 272H119.1C106.7 272 95.1 261.3 95.1 248C95.1 234.7 106.7 224 119.1 224H263.1zM167.1 320C181.3 320 191.1 330.7 191.1 344C191.1 357.3 181.3 368 167.1 368H119.1C106.7 368 95.1 357.3 95.1 344C95.1 330.7 106.7 320 119.1 320H167.1zM576 368C576 447.5 511.5 512 432 512C352.5 512 287.1 447.5 287.1 368C287.1 288.5 352.5 224 432 224C511.5 224 576 288.5 576 368zM476.7 324.7L416 385.4L387.3 356.7C381.1 350.4 370.9 350.4 364.7 356.7C358.4 362.9 358.4 373.1 364.7 379.3L404.7 419.3C410.9 425.6 421.1 425.6 427.3 419.3L499.3 347.3C505.6 341.1 505.6 330.9 499.3 324.7C493.1 318.4 482.9 318.4 476.7 324.7H476.7z"/></svg>
            <span>A retenir</span>
        </h2>
    </div>
    <x-basecore::inputs.wysiwyg name="note_global" :label="''" :value="$note_global" :livewire="true"/>
    <button wire:click="store" class="btn btn-primary mt-4">Sauvegarder</button>
</div>
