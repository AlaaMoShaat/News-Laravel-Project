<div>
    <input name="password" type="password" wire:model.live="password" class="form-control form-control-user"
        placeholder="Password">
    <div class="mt-2">
        @if ($passwordStrength)
            <span class="text-info">Password Strength: {{ $passwordStrength }}</span>
        @endif
    </div>
</div>
