<?php

namespace App\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Ramsey\Uuid\Codec\TimestampFirstCombCodec;
use Ramsey\Uuid\Codec\TimestampLastCombCodec;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\FeatureSet;
use Ramsey\Uuid\Generator\CombGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

trait HasUuid
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if ($field && in_array($field, $this->uuidColumns()) && ! Str::isUuid($value)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        if (! $field && in_array($this->getRouteKeyName(), $this->uuidColumns()) && ! Str::isUuid($value)) {
            throw (new ModelNotFoundException)->setModel(get_class($this), $value);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    public function getRouteKeyName()
    {
        return $this->uuidColumn();
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return $this->isKeyUuid() ? 'string' : $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return $this->isKeyUuid() ? false : $this->incrementing;
    }

    /**
     * Indicates if the IDs are UUIDs.
     *
     * @return bool
     */
    public function isKeyUuid(): bool
    {
        return false;
    }

    /**
     * The UUID type to use.
     * Which can be used time/random/timestamps-first/timestamps-last/nonstandard
     * Not recommended UUID type a nonstandard
     *
     * @return string
     */
    protected function uuidType(): string
    {
        return 'time';
    }

    /**
     * The name of the column that should be used for the UUID.
     *
     * @return string
     */
    public function uuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * The names of the columns that should be used for the UUID.
     *
     * @return array
     */
    public function uuidColumns(): array
    {
        return [$this->uuidColumn()];
    }

    /**
     * The "booting" method of the model.
     */
    public static function bootHasUuid(): void
    {
        static::creating(function (self $model): void {
            // Automatically generate a UUID if using them, and not provided.
            if ($model->isKeyUuid() && empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = $model->generateUuid();
            } else {
                foreach ($model->uuidColumns() as $item) {
                    $uuid = $model->generateUuid()->toString();

                    if (isset($model->attributes[$item]) && ! is_null($model->attributes[$item])) {
                        try {
                            $uuid = Uuid::fromString(strtolower($model->attributes[$item]));
                        } catch (InvalidUuidStringException $e) {
                            $uuid = Uuid::fromBytes($model->attributes[$item]);
                        }
                    }

                    $model->{$item} = strtolower($uuid);
                }
            }
        });
    }

    /**
     * @throws Exception
     * @return UuidInterface
     */
    protected function generateUuid(): UuidInterface
    {
        switch ($this->uuidType()) {
            case 'time':
                return Uuid::uuid1();
            case 'random':
                return Uuid::uuid4();
            case 'timestamps-first':
                return $this->generateOrderedUuid(true);
            case 'timestamps-last':
                return $this->generateOrderedUuid(true, false);
            case 'nonstandard':
                return $this->generateOrderedUuid(false, false, true);
        }

        throw new Exception(str_replace('{type}', $this->uuidType(), 'Uuid type {type} not supported'));
    }

    /**
     * Generate a ordered uuid
     *
     * @param boolean $codec
     * @param boolean $first
     * @param boolean $guid
     * @return UuidInterface
     */
    private function generateOrderedUuid(bool $codec = false, $first = true, $guid = false): UuidInterface
    {
        $factory = new UuidFactory(new FeatureSet($guid));

        if ($codec) {
            $factory->setCodec($first === true
                ? new TimestampFirstCombCodec($factory->getUuidBuilder())
                : new TimestampLastCombCodec($factory->getUuidBuilder())
            );
        }

        $factory->setRandomGenerator(new CombGenerator(
            $factory->getRandomGenerator(),
            $factory->getNumberConverter()
        ));

        return $factory->uuid4();
    }
}

