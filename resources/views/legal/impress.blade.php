@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">Impress</h1>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <p class="text-white">{{ config('legal.name')  }}</p>
                        <p class="text-white">{{ config('legal.street')  }}</p>
                        <p class="text-white">{{ config('legal.city')  }}</p>
                        <p class="text-white">{{ config('legal.country')  }}</p>

                        <p class="text-white">E-Mail: {{ config('legal.mail')  }}</p>

                        <p class="text-white">Verantwortlicher gemäß §10 Abs.3 MDStV:</p>
                        <p class="text-white">{{ config('legal.name')  }}</p>
                        <p class="text-white">{{ config('legal.street')  }}</p>
                        <p class="text-white">{{ config('legal.city')  }}</p>
                        <p class="text-white">{{ config('legal.country')  }}</p>

                        <h5 class="text-white">Inhalte und Haftungsausschluss</h5>
                        <p class="text-white">Die vorstehenden Informationen und Texte stellen keine Rechtsberatung dar. Insbesondere bilden sie nicht den konkreten Einzelfall ab. Für Richtigkeit und Aktualität kann daher keine Haftung übernommen werden. Falls Sie eine haftungssichere Auskunft wünschen, wenden Sie sich an unsere Kanzlei.
                            Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links. Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.</p>

                        <h5 class="text-white">Weitergabe</h5>
                        <p class="text-white">Sämtliche angebotenen Informationen dürfen – auch auszugsweise – nur mit schriftlicher Genehmigung von impressum-generator.de weiterverbreitet oder anderweitig veröffentlicht werden. Dies gilt nicht für die Erstellung eines Impressums durch Nutzung des Generators.</p>

                        <h5 class="text-white">Urheberrecht</h5>
                        <p class="text-white">Texte und Grafiken von impressum-generator.de sind durch das Urheberrecht geschützt. Das Verwenden der Texte und Grafiken von impressum-generator.de auf eigenen Web-Seiten oder in anderen Medien ohne ausdrückliche Genehmigung verletzt das Urheberrecht und wird bei Entdecken abgemahnt und falls notwendig auch gerichtlich verfolgt.</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection
