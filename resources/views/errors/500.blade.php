<div class="content">
    <div class="title">Something went wrong.</div>
@unless(empty($sentryID))
    <!-- Sentry JS SDK 2.1.+ required -->
        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
            Raven.showReportDialog({
                eventId: '{{ $sentryID }}',

                // use the public DSN (dont include your secret!)
                dsn: 'https://02b7d6196ecb432ba554bbd51e418ee4@sentry.aitouda.com/4'
            });
        </script>
    @endunless
</div>