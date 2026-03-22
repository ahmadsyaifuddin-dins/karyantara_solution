<div>
    <x-forms.label value="NPM / NIM" />
    <x-forms.input type="text" name="npm" value="{{ old('npm', $project->npm ?? '') }}" />
</div>
<div>
    <x-forms.label value="Kelas / Jurusan" />
    <x-forms.input type="text" name="class_name" value="{{ old('class_name', $project->class_name ?? '') }}" />
</div>
<div>
    <x-forms.label value="Dosen Pembimbing 1" />
    <x-forms.input type="text" name="dospem_1" value="{{ old('dospem_1', $project->dospem_1 ?? '') }}" />
</div>
<div>
    <x-forms.label value="Dosen Pembimbing 2" />
    <x-forms.input type="text" name="dospem_2" value="{{ old('dospem_2', $project->dospem_2 ?? '') }}" />
</div>
<div class="col-span-1 md:col-span-2">
    <x-forms.label value="Judul Skripsi / Judul Aplikasi (Fix)" />
    <x-forms.input type="text" name="skripsi_title"
        value="{{ old('skripsi_title', $project->skripsi_title ?? '') }}" />
</div>
