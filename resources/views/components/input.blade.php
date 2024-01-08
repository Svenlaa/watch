<div class="mt-4 first:mt-0 @if($inline ?? false) flex flex-row gap-2 justify-between @endif">
    <label class="text-sm font-medium text-gray-700 capitalize"
           for="{{$name.'Input'}}">{{$label ?? str_replace('_', ' ', $name)}}:</label>
    <input {{$attributes->except(['label, inline'])}} value="{{old($name) ?? ''}}" id="{{$name.'Input'}}"
           class="mt-1 @if (!($inline ?? false)) w-full @endif p-2 border {{$errors->get($name) ? 'border-red-500' : 'border-gray-300'}} rounded-md">
    @error($name)<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
</div>
