<?php

namespace App\Filament\Pages\Penjual;

use App\Services\Interfaces\CloudinaryServiceInterface;
use App\Services\ShopService;
use Filament\Forms;
use Filament\Pages\Actions\Action;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\Shop;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;

class PersonalShop extends Page
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.penjual.personal-shop';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'My Shop';
    protected static ?string $title = 'My Shop';
    protected static ?int $navigationSort = 1;

    public $shop = null;
    public $image;

    // Define the properties for form fields
    public $name;
    public $description;
    public $address;
    public $operational;

    public static function getRoutes(): array
    {
        return [
            static::getRoutePath() => static::getRouteCallback(),
        ];
    }

    public static function getRoutePath(): string
    {
        return '/my-shop';
    }

    protected function getFormModel(): ?Shop
    {
        return $this->shop;
    }

    public function mount(): void
    {
        if (Auth::user()->access !== 'penjual') {
            throw new AuthorizationException('You are not authorized to access this page.');
        }

        $this->shop = $this->getShop();

        if ($this->shop) {
            $this->form->fill([
                'name' => $this->shop->name,
                'description' => $this->shop->description,
                'address' => $this->shop->address,
                'operational' => $this->shop->operational,
                'image' => $this->shop->image ? $this->shop->image->path : null,
            ]);
        }
    }

    public function getShop(): ?Shop
    {
        return Auth::user()->shop ?? new Shop([
            'name' => '',
            'description' => '',
            'address' => '',
            'operational' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Shop Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Shop Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextArea::make('description')
                            ->label('Description')
                            ->required()
                            ->rows(5)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address')
                            ->label('Address')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('operational')
                            ->label('Operational Hours')
                            ->placeholder('e.g. Mon-Fri 09:00-17:00')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('shops')
                            ->maxSize(2048)
                            ->label('Product Image')
                            ->disk('public')
                            ->preserveFilenames()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('512')
                            ->imageResizeTargetHeight('512')
                            ->helperText('Max 2MB.')
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->action('save')
                ->label('Save Changes')
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if (isset($data['image'])) {
            if (is_string($data['image'])) {
                $data['image'] = [$data['image']];
            }
        }

        if ($this->shop) {
            if (isset($data['image'])) {
                $tempFile = Storage::disk('public')->get($data['image'][0]);
                $tempPath = Storage::disk('public')->path($data['image'][0]);

                $file = new \Illuminate\Http\UploadedFile(
                    $tempPath,
                    $data['image'][0],
                    Storage::disk('public')->mimeType($data['image'][0]),
                    null,
                    true
                );

                $data['image'] = $file;
            }

            $cloudinaryService = app(CloudinaryServiceInterface::class);
            $shopService = new ShopService($cloudinaryService);
            $shopService->updateShop($this->shop->id, $data);
        } else {
            $data['user_id'] = Auth::id();
            $this->shop = Shop::create($data);
        }

        Notification::make()
            ->success()
            ->title('Shop updated successfully')
            ->send();
    }
}
