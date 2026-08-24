@props(['nome', 'rotulo', 'obrigatorio' => false])

<label class="campo {{ $obrigatorio ? 'campo--obrigatorio' : '' }}">
    {{ $rotulo }}
    <input
        name="{{ $nome }}"
        type="text"
        inputmode="numeric"
        autocomplete="off"
        placeholder="dd/mm/aaaa"
        maxlength="10"
        pattern="\d{2}/\d{2}/\d{4}"
        data-date-picker
        {{ $obrigatorio ? 'required' : '' }}
    >
</label>
