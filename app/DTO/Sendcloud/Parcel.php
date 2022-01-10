<?php


namespace App\DTO\Sendcloud;


use App\DTO\AbstractDTO;

class Parcel extends AbstractDTO
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var string|null
     */
    private ?string $address;
    /**
     * @var string|null
     */
    private ?string $address2;
    /**
     * @var AddressDivided
     */
    private AddressDivided $addressDivided;
    /**
     * @var Carrier $carrier
     */
    private Carrier $carrier;
    /**
     * @var string|null
     */
    private ?string $city;
    /**
     * @var string|null
     */
    private ?string $companyName;
    /**
     * @var Country
     */
    private Country $country;
    /**
     * @var string|null
     */
    private ?string $customsInvoiceNr;
    /**
     * @var string
     */
    private string $orderNumber;
    /**
     * @var int|null
     */
    private ?int $customsShipmentType;
    /**
     * @var string|null
     */
    private ?string $dateCreated;
    /**
     * @var string|null
     */
    private ?string $dateUpdated;
    /**
     * @var string|null
     */
    private ?string $dateAnnounced;
    /**
     * @var string|null
     */
    private ?string $email;
    /**
     * @var int|null
     */
    private ?int $insuredValue;
    /**
     * @var string|null
     */
    private ?string $name;
    /**
     * @var string|null
     */
    private ?string $shipmentUuid;
    /**
     * @var ParcelItem[]
     */
    private array $items;
    /**
     * @var string|null
     */
    private ?string $postalCode;
    /**
     * @var Shipment
     */
    private Shipment $shipment;
    /**
     * @var Status
     */
    private Status $status;
    /**
     * @var Document[]
     */
    private array $documents;
    /**
     * @var string|null
     */
    private ?string $telephone;
    /**
     * @var string|null
     */
    private ?string $toServicePoint;
    /**
     * @var string|null
     */
    private ?string $toState;
    /**
     * @var string|null
     */
    private ?string $totalOrderValueCurrency;
    /**
     * @var string|null
     */
    private ?string $totalOrderValue;
    /**
     * @var string|null
     */
    private ?string $trackingNumber;
    /**
     * @var string|null
     */
    private ?string $trackingUrl;
    /**
     * @var string|null
     */
    private ?string $weight;

    /**
     * @var bool
     */
    private bool $is_return;

    /**
     * @var string|null
     */
    private ?string $external_order_id;

    /**
     * @return bool
     */
    public function isIsReturn(): bool
    {
        return $this->is_return;
    }

    /**
     * @param bool $is_return
     */
    public function setIsReturn(bool $is_return): void
    {
        $this->is_return = $is_return;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @param string|null $address2
     */
    public function setAddress2(?string $address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * @return AddressDivided
     */
    public function getAddressDivided(): AddressDivided
    {
        return $this->addressDivided;
    }

    /**
     * @param AddressDivided $addressDivided
     */
    public function setAddressDivided(AddressDivided $addressDivided): void
    {
        $this->addressDivided = $addressDivided;
    }

    /**
     * @return Carrier
     */
    public function getCarrier(): Carrier
    {
        return $this->carrier;
    }

    /**
     * @param Carrier $carrier
     */
    public function setCarrier(Carrier $carrier): void
    {
        $this->carrier = $carrier;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     */
    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getCustomsInvoiceNr(): ?string
    {
        return $this->customsInvoiceNr;
    }

    /**
     * @param string|null $customsInvoiceNr
     */
    public function setCustomsInvoiceNr(?string $customsInvoiceNr): void
    {
        $this->customsInvoiceNr = $customsInvoiceNr;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber(string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return int|null
     */
    public function getCustomsShipmentType(): ?int
    {
        return $this->customsShipmentType;
    }

    /**
     * @param int|null $customsShipmentType
     */
    public function setCustomsShipmentType(?int $customsShipmentType): void
    {
        $this->customsShipmentType = $customsShipmentType;
    }

    /**
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     */
    public function setDateCreated(?string $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return string|null
     */
    public function getDateUpdated(): ?string
    {
        return $this->dateUpdated;
    }

    /**
     * @param string|null $dateUpdated
     */
    public function setDateUpdated(?string $dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return string|null
     */
    public function getDateAnnounced(): ?string
    {
        return $this->dateAnnounced;
    }

    /**
     * @param string|null $dateAnnounced
     */
    public function setDateAnnounced(?string $dateAnnounced): void
    {
        $this->dateAnnounced = $dateAnnounced;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int|null
     */
    public function getInsuredValue(): ?int
    {
        return $this->insuredValue;
    }

    /**
     * @param int|null $insuredValue
     */
    public function setInsuredValue(?int $insuredValue): void
    {
        $this->insuredValue = $insuredValue;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getShipmentUuid(): ?string
    {
        return $this->shipmentUuid;
    }

    /**
     * @param string|null $shipmentUuid
     */
    public function setShipmentUuid(?string $shipmentUuid): void
    {
        $this->shipmentUuid = $shipmentUuid;
    }

    /**
     * @return ParcelItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ParcelItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return Shipment
     */
    public function getShipment(): Shipment
    {
        return $this->shipment;
    }

    /**
     * @param Shipment $shipment
     */
    public function setShipment(Shipment $shipment): void
    {
        $this->shipment = $shipment;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Document[]
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * @param Document[] $documents
     */
    public function setDocuments(array $documents): void
    {
        $this->documents = $documents;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string|null $telephone
     */
    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string|null
     */
    public function getToServicePoint(): ?string
    {
        return $this->toServicePoint;
    }

    /**
     * @param string|null $toServicePoint
     */
    public function setToServicePoint(?string $toServicePoint): void
    {
        $this->toServicePoint = $toServicePoint;
    }

    /**
     * @return string|null
     */
    public function getToState(): ?string
    {
        return $this->toState;
    }

    /**
     * @param string|null $toState
     */
    public function setToState(?string $toState): void
    {
        $this->toState = $toState;
    }

    /**
     * @return string|null
     */
    public function getTotalOrderValueCurrency(): ?string
    {
        return $this->totalOrderValueCurrency;
    }

    /**
     * @param string|null $totalOrderValueCurrency
     */
    public function setTotalOrderValueCurrency(?string $totalOrderValueCurrency): void
    {
        $this->totalOrderValueCurrency = $totalOrderValueCurrency;
    }

    /**
     * @return string|null
     */
    public function getTotalOrderValue(): ?string
    {
        return $this->totalOrderValue;
    }

    /**
     * @param string|null $totalOrderValue
     */
    public function setTotalOrderValue(?string $totalOrderValue): void
    {
        $this->totalOrderValue = $totalOrderValue;
    }

    /**
     * @return string|null
     */
    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    /**
     * @param string|null $trackingNumber
     */
    public function setTrackingNumber(?string $trackingNumber): void
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return string|null
     */
    public function getTrackingUrl(): ?string
    {
        return $this->trackingUrl;
    }

    /**
     * @param string|null $trackingUrl
     */
    public function setTrackingUrl(?string $trackingUrl): void
    {
        $this->trackingUrl = $trackingUrl;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     */
    public function setWeight(?string $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string|null
     */
    public function getExternalOrderId(): ?string
    {
        return $this->external_order_id;
    }

    /**
     * @param string|null $external_order_id
     */
    public function setExternalOrderId(?string $external_order_id): void
    {
        $this->external_order_id = $external_order_id;
    }

    /**
     * @inheritDoc
     * @return Parcel
     */
    public static function fromArray(array $data): Parcel
    {
        $parcel = new self();
        $parcel->id = static::getValue($data, 'id');
        $parcel->address = static::getValue($data, 'address');
        $parcel->address2 = static::getValue($data, 'address_2');
        $parcel->addressDivided = AddressDivided::fromArray(static::getValue($data, 'address_divided', []));
        $parcel->carrier = Carrier::fromArray(static::getValue($data, 'carrier', []));
        $parcel->city = static::getValue($data, 'city');
        $parcel->companyName = static::getValue($data, 'company_name');
        $parcel->country = Country::fromArray(static::getValue($data, 'country', []));
        $parcel->customsInvoiceNr = static::getValue($data, 'customs_invoice_nr');
        $parcel->customsShipmentType = static::getValue($data, 'customs_shipment_type', null);
        $parcel->dateCreated = static::getValue($data, 'date_created');
        $parcel->dateUpdated = static::getValue($data, 'date_updated');
        $parcel->dateAnnounced = static::getValue($data, 'date_announced');
        $parcel->email = static::getValue($data, 'email', null);
        $parcel->insuredValue = static::getValue($data, 'insured_value', 0);
        $parcel->name = static::getValue($data, 'name');
        $parcel->orderNumber = static::getValue($data, 'order_number');
        $parcel->shipmentUuid = static::getValue($data, 'shipment_uuid', null);
        $parcel->items = ParcelItem::fromBatch(static::getValue($data, 'parcel_items', []));
        $parcel->postalCode = static::getValue($data, 'postal_code');
        $parcel->shipment = Shipment::fromArray(static::getValue($data, 'shipment', []));
        $parcel->status = Status::fromArray(static::getValue($data, 'status', []));
        $parcel->documents = Document::fromBatch(static::getValue($data, 'documents', []));
        $parcel->telephone = static::getValue($data, 'telephone');
        $parcel->toServicePoint = static::getValue($data, 'to_service_point', null);
        $parcel->toState = static::getValue($data, 'to_state');
        $parcel->totalOrderValueCurrency = static::getValue($data, 'total_order_value_currency');
        $parcel->totalOrderValue = static::getValue($data, 'total_order_value');
        $parcel->trackingNumber = static::getValue($data, 'tracking_number');
        $parcel->trackingUrl = static::getValue($data, 'tracking_url');
        $parcel->is_return = static::getValue($data, 'is_return');
        $parcel->external_order_id = static::getValue($data, 'external_order_id');

        return $parcel;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [];
    }
}
