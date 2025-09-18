<?php

namespace CwsDigital\TwillRedirects\Twill\Capsules\Redirects\Http\Controllers;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Option;
use A17\Twill\Services\Forms\Options;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class RedirectController extends BaseModuleController
{
    protected $moduleName = 'redirects';

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->setTitleColumnKey('from');
    }

    public function getCreateForm(): Form
    {
        $form = new Form();

        $form->add(
            Input::make()->name('from')->label(__('redirect.from'))->maxLength(250)
                ->note(__('redirect.from_note'))
        );

        $form->add(
            Input::make()->name('to')->label(__('redirect.to'))->maxLength(250)
                ->note(__('redirect.to_note'))
        );

        $form->add(
            Select::make()
                ->name('status_code')
                ->label(__('redirect.status_code'))
                ->default(301)
                ->options(
                    Options::make([
                        Option::make(301, __('redirect.301')),
                        Option::make(302, __('redirect.302')),
                    ])
                )
        );

        return $form;
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->addFieldset(
            Fieldset::make()->title('Redirect')->id('redirect')
                ->fields([
                    Input::make()->name('from')->label(__('redirect.from'))->maxLength(250)
                        ->note(__('redirect.from_note')),
                    Input::make()->name('to')->label(__('redirect.to'))->maxLength(250)
                        ->note(__('redirect.to_note')),
                    Select::make()
                        ->name('status_code')
                        ->label(__('redirect.status_code'))
                        ->default(301)
                        ->options(
                            Options::make([
                                Option::make(301, __('redirect.301')),
                                Option::make(302, __('redirect.302')),
                            ])
                        ),
                ])
        );

        return $form;
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('to')->title(__('redirect.to'))
        );

        $table->add(
            Text::make()->field('status_code')->title(__('redirect.status_code'))
        );

        return $table;
    }
}
