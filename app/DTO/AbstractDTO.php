<?php


namespace App\DTO;


abstract class AbstractDTO
{
    /**
     * Returns array representation of dto.
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Creates instance from an array;
     *
     * @param array $data
     *
     * @return AbstractDTO
     */
    abstract public static function fromArray(array $data): AbstractDTO;

    /**
     * Returns array representation of DTOs
     *
     * @param AbstractDTO[] $DTOs
     *
     * @return array
     */
    public static function toBatch(array $DTOs): array
    {
        $results = [];
        foreach ($DTOs as $DTO) {
            $results[] = $DTO->toArray();
        }

        return $results;
    }

    /**
     * Creates collection of Dtos from data batch.
     *
     * @param array $batch
     *
     * @return AbstractDTO[]
     */
    public static function fromBatch(array $batch): array
    {
        $result = [];
        foreach ($batch as $data) {
            $result[] = static::fromArray($data);
        }

        return $result;
    }

    /**
     * Gets value from the array for given key.
     *
     * @param array $search An array with keys to check.
     * @param string $key Key to get value for.
     * @param mixed $default Default value if key is not present.
     *
     * @return mixed Value from the array for given key if key exists; otherwise, $default value.
     */
    protected static function getValue(array $search, string $key, $default = ''): mixed
    {
        return array_key_exists($key, $search) ? $search[$key] : $default;
    }
}
