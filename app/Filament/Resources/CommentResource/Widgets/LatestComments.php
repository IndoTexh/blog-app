<?php

namespace App\Filament\Resources\CommentResource\Widgets;

use Carbon\Carbon;
use Filament\Tables;
use App\Models\Comment;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Actions;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\CommentResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestComments extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comment::whereDate('created_at', '>', now()->subDays(14)->startOfDay())
            )
            ->columns([
                TextColumn::make('post.title'),
                TextColumn::make('user.name'),
                TextColumn::make('comment'),
                TextColumn::make('created_at')->date()->sortable(),

            ])->actions([
                Action::make('View')
                ->url(fn(Comment $record) : string => CommentResource::getUrl('edit', ['record' => $record]))->openUrlInNewTab() 
            ]);
    }
}
