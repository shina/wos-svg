<div x-data='{!! json_encode($data) !!}'>
    <select @change="changeLanguage($event)">
        <template x-for="{ language, label, isSelected } in languages">
            <option :selected="isSelected" :value="language" x-text="label"></option>
        </template>
    </select>
</div>
<script>
    async function changeLanguage(event) {
        const language = event.target.value;
        const url = new URL('{{ url('/locale-selection/api/change') }}');
        url.searchParams.set('locale', language);

        const response = await fetch(url.toString())
        if (response.ok) {
            document.location.reload();
        }
    }
</script>
