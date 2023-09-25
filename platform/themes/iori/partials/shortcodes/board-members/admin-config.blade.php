@php
    $teamIds = explode(',', Arr::get($attributes, 'team_ids'));
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Choose teams') }}</label>
        <select class="select-full" name="team_ids" multiple>
            @foreach($teams as $team)
                <option @selected(in_array($team->id, $teamIds)) value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
</section>
