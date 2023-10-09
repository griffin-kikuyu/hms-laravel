@foreach($doctors as $doctor)
    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
@endforeach