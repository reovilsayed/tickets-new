<!-- resources/views/privacy-policy.blade.php -->

@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('css')
<style>
    p, ul, li {
        color: white !important;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <h1 class="mb-4 mt-4">Privacy Policy</h1>

    <p>Effective Date: {{ now()->toFormattedDateString() }}</p>

    <p>This Privacy Policy explains how we collect, use, and protect your personal information when you use our website or services.</p>

    <h2>1. Information We Collect</h2>
    <ul>
        <li><strong>Personal Information:</strong> such as name, email address, and phone number when you register or contact us.</li>
        <li><strong>Usage Data:</strong> such as IP address, browser type, pages visited, and time spent on the site.</li>
        <li><strong>Cookies:</strong> to improve your experience and for analytics purposes.</li>
    </ul>

    <h2>2. How We Use Your Information</h2>
    <ul>
        <li>To provide and maintain our service</li>
        <li>To communicate with you</li>
        <li>To improve our website and user experience</li>
        <li>To comply with legal obligations</li>
    </ul>

    <h2>3. Sharing Your Information</h2>
    <p>We do not sell or trade your personal data. We may share your information with trusted third-party service providers who help us operate our website, provided they agree to keep your information confidential.</p>

    <h2>4. Data Security</h2>
    <p>We implement a variety of security measures to maintain the safety of your personal information.</p>

    <h2>5. Your Rights</h2>
    <p>You may request access, correction, or deletion of your personal data by contacting us.</p>

    <h2>6. Third-Party Links</h2>
    <p>Our site may contain links to other websites. We are not responsible for the content or privacy practices of those sites.</p>

    <h2>7. Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated effective date.</p>

    <h2>8. Contact Us</h2>
    <p>If you have any questions about this Privacy Policy, please contact us at: <a href="mailto:support@example.com">support@example.com</a></p>
</div>
@endsection
