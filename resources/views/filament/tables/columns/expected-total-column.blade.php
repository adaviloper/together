<div
    {{
        $getExtraAttributeBag()
            ->class([
                'text-start' => $getAlignment() === 'start' || $getAlignment() === 'left',
                'text-center' => $getAlignment() === 'center',
                'text-end' => $getAlignment() === 'end' || $getAlignment() === 'right',
            ])
    }}
>
    {{ $getExpectedTotal() }}
</div>
