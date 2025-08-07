@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
    <div class="text-center fade-in">
        <div class="spinner-border text-primary mb-4" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h4 class="mb-2">Processing your request...</h4>
        <p class="text-muted">Downloading PDF and redirecting you shortly.</p>
    </div>
</div>

<style>
    .fade-in {
        animation: fadeIn 1.2s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pdfUrl = "{{ route('applications.pdf', ['id' => $id]) }}";

        // Create a hidden download link
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = '';
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Redirect to index after 2 seconds
        setTimeout(() => {
            window.location.href = "{{ route('applications.index') }}";
        }, 2000);
    });
</script>
@endsection
