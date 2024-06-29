<?php

class Entry {
    private string $type;
    private float $amount;
    private Category $category;
    private string $description;

    public function __construct(string $type, float $amount, Category $category, string $description) {
        $this->type = $type;
        $this->amount = $amount;
        $this->category = $category;
        $this->description = $description;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getCategory(): Category {
        return $this->category;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function toArray(): array {
        return [
            'type' => $this->type,
            'amount' => $this->amount,
            'category' => $this->category->getName(),
            'description' => $this->description,
        ];
    }

    public static function fromArray(array $data): Entry {
        return new Entry(
            $data['type'],
            $data['amount'],
            new Category($data['category']),
            $data['description']
        );
    }
}
