<div class="contact-card">
    <h3 class="form-card-title">{{ $title }}</h3>
    @if (! empty($subtitle))
        <p class="form-card-sub">{!! $subtitle !!}</p>
    @endif

    <form id="trialForm"
          data-url="{{ route('contact.submission') }}"
          data-google-url="{{ config('services.google_sheets.form_url', '') }}">
        <div class="form-row">
            <div class="form-group">
                <label for="studentName">Nom de l'élève *</label>
                <input type="text" id="studentName" name="student_name" placeholder="Entrez le nom de l'élève" required>
            </div>
            <div class="form-group">
                <label for="parentName">Nom du parent *</label>
                <input type="text" id="parentName" name="parent_name" placeholder="Entrez votre nom" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="studentAge">Âge de l'élève *</label>
                <input type="number" id="studentAge" name="student_age" placeholder="Ex: 8" min="3" max="80" required>
            </div>
            <div class="form-group">
                <label for="phone">Numéro WhatsApp *</label>
                <input type="tel" id="phone" name="phone" placeholder="+33 6 00 00 00 00" required>
            </div>
        </div>
        <div class="form-group">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" placeholder="example@email.com">
        </div>
        <div class="form-group">
            <label for="level">Niveau de l'élève (optionnel)</label>
            <input type="text" id="level" name="level" placeholder="Ex: Débutant, Intermédiaire, Avancé...">
        </div>
        <div class="form-group">
            <label for="schedule">Créneaux souhaités (optionnel)</label>
            <input type="text" id="schedule" name="schedule" placeholder="Ex: Jours de semaine après 17h, week-end...">
        </div>
        <div class="form-group">
            <label for="message">Message supplémentaire (optionnel)</label>
            <textarea id="message" name="message" placeholder="Avez-vous une demande ou une question particulière ?"></textarea>
        </div>

        <button type="submit" class="form-submit" id="submitBtn">
            Envoyer ma demande et attendre le contact
        </button>
    </form>
</div>