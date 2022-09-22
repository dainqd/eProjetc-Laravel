@switch($status)
    @case(\App\Enums\OrderStatus::CREATED)
    <span
        class="badge bg-danger">{{ \App\Enums\OrderStatus::getDescription($status) }}</span>
    @break
    @case(\App\Enums\OrderStatus::PAID)
    <span
        class="badge bg-warning">{{ \App\Enums\OrderStatus::getDescription($status) }}</span>
    @break
    @case(\App\Enums\OrderStatus::IN_DELIVERY)
    <span
        class="badge bg-info">{{ \App\Enums\OrderStatus::getDescription($status) }}</span>
    @break
    @case(\App\Enums\OrderStatus::COMPLETED)
    <span
        class="badge bg-success">{{ \App\Enums\OrderStatus::getDescription($status) }}</span>
    @break
    @case(\App\Enums\OrderStatus::CANCELED)
    <span
        class="badge bg-dark">{{ \App\Enums\OrderStatus::getDescription($status) }}</span>
    @break
@endswitch
