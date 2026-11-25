"""Generates the subpage patterns (full-page starters + individual sections) for the Dermatex theme."""
import json, os, glob

OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'patterns')
CONSTRAINED = {"type": "constrained", "wideSize": "1312px"}


def J(a):
    return json.dumps(a, separators=(',', ':'), ensure_ascii=False)


def img_url(name):
    return f"<?php echo esc_url( get_theme_file_uri( 'assets/img/{name}' ) ); ?>"


# ---------- block helpers (markup matches WordPress serialization) ----------
def grp(inner, cls='', align=None, tag=None, anchor=None, layout=None):
    a = {}
    if tag: a['tagName'] = tag
    if anchor: a['anchor'] = anchor
    if align: a['align'] = align
    if cls: a['className'] = cls
    a['layout'] = layout or {"type": "default"}
    t = tag or 'div'
    classes = 'wp-block-group' + (' align' + align if align else '') + (' ' + cls if cls else '')
    idattr = f' id="{anchor}"' if anchor else ''
    return f'<!-- wp:group {J(a)} -->\n<{t}{idattr} class="{classes}">\n{inner}\n</{t}>\n<!-- /wp:group -->\n'


def band(style, inner, anchor=None, cls=''):
    """Full-bleed section: the section spans the viewport; content sits in the 1312px container."""
    c = ('dx-section is-style-band-' + style + (' ' + cls if cls else ''))
    return grp(grp(inner, 'dx-stack', align='wide'), c, tag='section', anchor=anchor, layout=CONSTRAINED)


def eyebrow(t, cls=''):
    c = 'dx-eyebrow' + (' ' + cls if cls else '')
    return f'<!-- wp:paragraph {{"className":"{c}"}} -->\n<p class="{c}">{t}</p>\n<!-- /wp:paragraph -->\n'


def h(level, t, cls='', anchor=None):
    a = {}
    if level != 2: a['level'] = level
    if anchor: a['anchor'] = anchor
    if cls: a['className'] = cls
    aj = (' ' + J(a)) if a else ''
    c = 'wp-block-heading' + (' ' + cls if cls else '')
    idattr = f' id="{anchor}"' if anchor else ''
    return f'<!-- wp:heading{aj} -->\n<h{level} class="{c}"{idattr}>{t}</h{level}>\n<!-- /wp:heading -->\n'


def p(t, cls=''):
    a = f' {{"className":"{cls}"}}' if cls else ''
    c = f' class="{cls}"' if cls else ''
    return f'<!-- wp:paragraph{a} -->\n<p{c}>{t}</p>\n<!-- /wp:paragraph -->\n'


def ul(items, cls='', ordered=False):
    tag = 'ol' if ordered else 'ul'
    a = {}
    if ordered: a['ordered'] = True
    if cls: a['className'] = cls
    aj = (' ' + J(a)) if a else ''
    li = ''.join(f'<!-- wp:list-item -->\n<li>{i}</li>\n<!-- /wp:list-item -->\n' for i in items)
    c = 'wp-block-list' + (' ' + cls if cls else '')
    return f'<!-- wp:list{aj} -->\n<{tag} class="{c}">{li}</{tag}>\n<!-- /wp:list -->\n'


def button(label, href, style=None):
    a = {}
    cls = ''
    if style:
        cls = f'is-style-{style}'
        a['className'] = cls
    aj = (' ' + J(a)) if a else ''
    wc = 'wp-block-button' + (' ' + cls if cls else '')
    return f'<!-- wp:button{aj} -->\n<div class="{wc}"><a class="wp-block-button__link wp-element-button" href="{href}">{label}</a></div>\n<!-- /wp:button -->\n'


def buttons(*bs, cls=''):
    a = f' {{"className":"{cls}"}}' if cls else ''
    c = 'wp-block-buttons' + (' ' + cls if cls else '')
    return f'<!-- wp:buttons{a} -->\n<div class="{c}">\n' + ''.join(bs) + '</div>\n<!-- /wp:buttons -->\n'


def image(name, alt, cls=''):
    a = {"sizeSlug": "large", "linkDestination": "none", "lightbox": {"enabled": True}}
    if cls: a['className'] = cls
    c = 'wp-block-image size-large' + (' ' + cls if cls else '')
    return (f'<!-- wp:image {J(a)} -->\n<figure class="{c}"><img src="{img_url(name)}" alt="{alt}"/></figure>\n<!-- /wp:image -->\n')


def hero_bg(name):
    """Banner image: plain image block (editable with Replace), positioned behind the hero text by CSS."""
    a = {"sizeSlug": "full", "linkDestination": "none", "className": "dx-subhero__bg"}
    return (f'<!-- wp:image {J(a)} -->\n<figure class="wp-block-image size-full dx-subhero__bg"><img src="{img_url(name)}" alt=""/></figure>\n<!-- /wp:image -->\n')


def table(head, rows, cls='dx-table'):
    th = ''.join(f'<th>{c}</th>' for c in head)
    tb = ''.join('<tr>' + ''.join(f'<td>{c}</td>' for c in r) + '</tr>' for r in rows)
    return (f'<!-- wp:table {{"className":"{cls}"}} -->\n<figure class="wp-block-table {cls}"><table class="has-fixed-layout">'
            f'<thead><tr>{th}</tr></thead><tbody>{tb}</tbody></table></figure>\n<!-- /wp:table -->\n')


def details(q, a, open_=False):
    at = {"className": "dx-faq__item"}
    if open_: at['showContent'] = True
    o = ' open' if open_ else ''
    return (f'<!-- wp:details {J(at)} -->\n<details class="wp-block-details dx-faq__item"{o}><summary>{q}</summary>\n'
            f'<!-- wp:paragraph -->\n<p>{a}</p>\n<!-- /wp:paragraph --></details>\n<!-- /wp:details -->\n')


def faq(items):
    return grp(''.join(details(q, a, i == 0) for i, (q, a) in enumerate(items)), 'dx-faq')


def compare(pb, pa, caption=''):
    a = {"placeholderBefore": pb, "placeholderAfter": pa, "caption": caption}
    return f'<!-- wp:dermatex/compare {J(a)} /-->\n'


def ph(label, text, cls=''):
    c = 'dx-ph' + (' ' + cls if cls else '')
    return f'<!-- wp:paragraph {{"className":"{c}"}} -->\n<p class="{c}"><strong>{label}</strong>{text}</p>\n<!-- /wp:paragraph -->\n'


BOOK = '/#contact'
TEL = 'tel:+19493052661'


# ---------- sections ----------
def hero(kind, crumbs_eyebrow, h1, intro, bg):
    inner = (
        p('[dx_breadcrumb]', 'dx-crumbs') +
        eyebrow(crumbs_eyebrow) +
        h(1, h1) +
        p(intro, 'dx-lede') +
        buttons(button('Book a Consultation', BOOK, 'gold'), button('Call (949) 305-2661', TEL, 'outline'))
    )
    body = (hero_bg(bg) if bg else '') + grp(grp(inner, 'dx-subhero__text dx-stack'), '', align='wide')
    return grp(body, f'dx-subhero dx-subpage--{kind}', tag='section', layout=CONSTRAINED)


def contact_band(style='canvas', heading='Schedule your private consultation'):
    head = grp(
        grp(eyebrow('Let’s talk about you') + h(2, heading) +
            p('A free, private conversation. About one hour, in our Laguna Hills studio or by Zoom.'), 'dx-stack') +
        buttons(button('Book a Consultation', BOOK), button('Call (949) 305-2661', TEL, 'outline'), cls='dx-contact__buttons'),
        'dx-contact__head')
    info = grp(
        grp(eyebrow('Call the studio') + p('<a href="tel:+19493052661">(949) 305-2661</a>'), 'dx-stack') +
        grp(eyebrow('Visit Laguna Hills') + p('23201 Mill Creek Dr #225<br>Laguna Hills, CA 92653'), 'dx-stack') +
        grp(eyebrow('Studio hours') + p('Mon–Fri 9–6 · Sat 9–5<br>Sun closed'), 'dx-stack'),
        'dx-contact__info')
    zoom = p('<a href="/#contact">Virtual Zoom consult ↗</a>', 'dx-contact__zoom')
    return band(style, head + info + zoom, cls='dx-contact', anchor=None)


def consult_card(copy='Bring your questions to a free, private consultation.'):
    return grp(h(3, 'You don’t have to figure it out alone.') + p(copy) + buttons(button('Book a Consultation', BOOK, 'gold')), 'dx-aside-cta')


def article_cards(cards, eyebrow_default=None):
    out = ''
    for (name, ey, title, text, alt) in cards:
        out += grp(
            image(name, alt) +
            grp(eyebrow(ey) + h(3, title) + p(text) + p('<a href="/blog/">Read article →</a>'), 'dx-product__body'),
            'dx-product')
    return grp(out, 'dx-grid dx-grid--3')


def service_cards(cards):
    out = ''
    for (name, title, href, alt) in cards:
        out += grp(
            image(name, alt) +
            grp(eyebrow('Explore your options') + h(3, title) + p('Personal guidance, with space for your questions.') +
                p(f'<a href="{href}">Explore this service →</a>'), 'dx-product__body'),
            'dx-product')
    return grp(out, 'dx-grid dx-grid--3')


# ----- Option 1: Informational -----
def info_hero():
    return hero('info', 'Information / Know your options', 'Men’s Hair Loss Causes',
                'Understand common causes, know when to ask for medical advice and explore your next step in private.',
                'sample-hair-swatches.jpg')


def info_intro():
    toc = grp(
        eyebrow('On this page') +
        ul(['<a href="#genetics">Genetics</a>', '<a href="#stress">Stress</a>', '<a href="#medical-conditions">Medical conditions</a>',
            '<a href="#medication">Medication</a>', '<a href="#when-to-talk-to-a-doctor">When to talk to a doctor</a>'], 'dx-tocnav__list') +
        consult_card(),
        'dx-tocnav')
    main = grp(
        p('[dx_reading_time] · Last reviewed: [date to confirm]', 'dx-meta-line') +
        eyebrow('A private start') +
        h(2, 'Understanding what may be behind hair loss.') +
        p('Noticing a change in your hair can bring up questions. Hair loss can have more than one cause; understanding the pattern and timing is a useful first step.') +
        p('This guide offers general information, not a diagnosis. A qualified healthcare professional can help investigate changes in your hair or scalp.'),
        'dx-info-main dx-stack')
    layout = grp(main + grp(toc, 'dx-info-aside'), 'dx-info-layout')
    return grp(grp(layout, '', align='wide'), 'dx-section is-style-band-canvas', tag='section', layout=CONSTRAINED)


def key_takeaways():
    return band('soft', eyebrow('The short version') + h(2, 'Key takeaways') +
                ul(['Genetics, stress, health conditions and medicines can all play a role.',
                    'Pattern and timing can help a clinician assess a change.',
                    'Sudden or unexplained loss deserves medical guidance first.',
                    'Cosmetic choices can be explored in a private conversation.'], 'dx-bullets'))


def info_body():
    def sec(n, label, anchor, title, p1, p2):
        return grp(eyebrow(f'{n} / {label}') + h(2, title, anchor=anchor) + p(p1) + p(p2), 'dx-prose__section dx-stack')
    body = (
        sec('01', 'Genetics', 'genetics', 'Genetics',
            'An inherited tendency can influence how hair changes over time. Some people notice a gradually receding hairline or thinning at the crown. A clinician can help distinguish a patterned change from other causes.',
            'Note your family history, where thinning appears and when you first noticed it.') +
        sec('02', 'Stress', 'stress', 'Stress',
            'Significant physical or emotional stress may be followed by increased shedding. Timing varies, and other factors may be involved. If the change worries you, speak with a healthcare professional rather than assuming stress is the cause.',
            'Keep a record of the timing and any other changes in your health or routine.') +
        sec('03', 'Your health', 'medical-conditions', 'Medical conditions',
            'Some health conditions can affect hair growth or the scalp. Patchy loss, discomfort or a rapid change is a reason to seek medical advice. A cosmetic consultation is not a substitute for a medical assessment.',
            'Ask your healthcare professional which questions or tests, if any, are appropriate.') +
        sec('04', 'Medication', 'medication', 'Medication',
            'Certain medicines can be associated with changes in hair. Do not stop or adjust a prescribed medicine on your own. Your prescriber or pharmacist can discuss possible effects and safe next steps.',
            'Bring an up-to-date list of medicines and supplements to your appointment.') +
        grp(h(3, 'When to talk to a doctor first', anchor='when-to-talk-to-a-doctor') +
            p('Seek medical advice for sudden, patchy or unexplained hair loss, or scalp pain, redness or irritation. Dermatex can discuss cosmetic choices after medical concerns have been addressed.'),
            'dx-callout') +
        grp(p('“A little information can make the next conversation feel easier.”', 'dx-pullquote') +
            ul(['Note what has changed.', 'Talk with a qualified healthcare professional.', 'Explore cosmetic options when you feel ready.'], 'dx-pullsteps', ordered=True),
            'dx-prose__section dx-stack')
    )
    return band('white', grp(body, 'dx-prose dx-prose--sections'))


def compare_table():
    return band('canvas',
                eyebrow('Options / At a glance') + h(2, 'Different approaches. Different conversations.') +
                p('A starting point for questions—not a recommendation or a promise of results.') +
                table(['Approach', 'What it involves', 'A question to ask'],
                      [['Hair system', 'A custom cosmetic hair solution', 'How will it fit my routine?'],
                       ['Hair transplant', 'A surgical procedure with a medical provider', 'Am I a suitable candidate?'],
                       ['Medication', 'A treatment discussed with a prescriber', 'What are the risks and follow-up?']]) +
                p('Swipe horizontally to compare all columns →', 'dx-swipe-hint'))


def info_faq():
    return band('white', eyebrow('Good questions') + h(2, 'A little clarity, before we meet.') +
                faq([('Can Dermatex diagnose my hair loss?', 'No. Ask a healthcare professional about the cause.'),
                     ('What happens at a consultation?', 'A free, private conversation of about one hour, in our Laguna Hills studio or by Zoom. Your questions come first.'),
                     ('Can I meet by Zoom?', 'Yes. A virtual Zoom consultation is available.')]))


def keep_exploring():
    cards = article_cards([
        ('sample-man-beach.jpg', 'Hair systems', 'A hair system that fits your everyday life', 'Explore a personal approach to everyday hair.', 'A man walking on a beach'),
        ('sample-studio-consult.jpg', 'Getting started', 'Your first consultation: what to expect', 'A private conversation, with your questions first.', 'A specialist and a client talking at a table'),
        ('sample-hair-swatches.jpg', 'Getting started', 'Hair systems, wigs and toppers', 'Understand the choices before you decide.', 'Hair color swatches beside a comb'),
    ])
    mobile_card = grp(consult_card('Start with a free, private conversation. About one hour, in studio or by Zoom.'), 'dx-only-mobile')
    return band('soft', eyebrow('Keep exploring') + h(2, 'A little more guidance.') + cards + mobile_card)


# ----- Option 2: Media -----
def media_hero():
    return hero('media', 'Real lives / Personal stories', 'Your story starts with you.',
                'Different experiences. Personal choices. Explore the stories behind a more confident everyday.',
                'sample-studio-consult.jpg')


def media_intro():
    return band('canvas', eyebrow('The people behind the hair') + h(2, 'A personal choice, in their own words.') +
                p('Take your time exploring. Every person’s starting point, routine and preferences are different. Your own consultation is a place to discuss what matters to you.') +
                p('Layout previews use editorial imagery, not client results. Replace with approved photos, names and timelines before publishing.', 'dx-note'))


def tile(name_or_none, alt, title, meta, note, cats, compare_block=False):
    top = (grp(compare('Approved before photo pending', 'Approved after photo pending'), 'dx-tile__compare') if compare_block
           else image(name_or_none, alt, 'dx-tile__img'))
    body = grp(h(3, title) + p(meta) + p(note, 'dx-note'), 'dx-tile__body')
    return grp(top + body, 'dx-tile ' + ' '.join('dx-cat-' + c for c in cats) + (' dx-tile--compare' if compare_block else ''))


def gallery():
    tiles = (
        tile(None, '', 'Before &amp; after / hair systems', 'First name · Service · Timeline to confirm', 'Approved client photography pending', ['men', 'hair-systems'], True) +
        tile('sample-man-beach.jpg', 'A man walking on a beach', 'Hair systems / everyday life', 'First name · Hair systems · Timeline to confirm', 'Editorial preview · not a client result', ['men', 'hair-systems']) +
        tile('sample-woman-garden.jpg', 'A smiling woman outdoors', 'Women’s hair / a personal fit', 'First name · Women’s hair · Timeline to confirm', 'Editorial preview · not a client result', ['women']) +
        tile('sample-man-bench.jpg', 'A man sitting on a bench by the coast', 'SMP / explore the detail', 'First name · SMP · Timeline to confirm', 'Editorial preview · not a client result', ['men', 'smp']) +
        tile('sample-studio-consult.jpg', 'A specialist and a client talking at a table', 'In the studio / first steps', 'First name · Consultation · Timeline to confirm', 'Editorial preview · not a client result', ['men', 'women']) +
        tile('sample-hair-swatches.jpg', 'Hair color swatches beside a comb', 'Hair additions / your options', 'First name · Hair additions · Timeline to confirm', 'Editorial preview · not a client result', ['women', 'extensions'])
    )
    return band('soft',
                p('Photos shared with client permission.', 'dx-gallery-status') +
                grp(tiles, 'dx-gallery') +
                buttons(button('Load more stories', '#gallery', 'gold'), cls='dx-load-more'),
                anchor='gallery')


def video_band():
    main = grp(ph('YouTube video · replace with an Embed block', 'Your first private consultation · Duration [00:00] · Approved video pending', 'dx-ph--video dx-ph--16x9'), 'dx-video-main')
    thumbs = grp(
        ph('YouTube · [00:00]', 'Spencer’s story · Video pending', 'dx-ph--video dx-ph--16x9') +
        ph('YouTube · [00:00]', 'Monique’s story · Video pending', 'dx-ph--video dx-ph--16x9') +
        ph('YouTube · [00:00]', 'How it works · Video pending', 'dx-ph--video dx-ph--16x9'),
        'dx-grid dx-grid--3 dx-video-grid')
    return band('navy', eyebrow('Watch / Listen / Take your time') + h(2, 'A closer look at a personal process.') +
                p('Meet the people behind the conversation. Choose a film, watch at your own pace or read the transcript.') +
                main + p('<a href="#transcript">Read the transcript ↗</a>') + thumbs, cls='dx-videos')


def story_split():
    left = image('sample-man-beach.jpg', 'A man walking on a beach at sunset', 'dx-split__img')
    right = grp(eyebrow('Spencer / A personal story') +
                p('“I don’t wear one any more because I want to show off my hair.”', 'dx-story__quote') +
                p('Spencer · Dermatex client', 'dx-attrib') +
                p('Male pattern baldness and a receding hairline affected Spencer’s confidence. His story begins with a private conversation.') +
                p('<a href="/#stories">Read full story →</a>') +
                p('Quote reused from the homepage. Editorial photo shown for layout only.', 'dx-note'), 'dx-stack')
    return band('canvas', grp(left + right, 'dx-grid dx-grid--2 dx-split'))


# ----- Option 3: Service -----
def service_hero():
    return hero('service', 'SMP / Scalp micropigmentation', 'Scalp Micropigmentation',
                'Explore the appearance of fuller-looking hair with personal guidance in a private Laguna Hills studio.',
                'sample-man-beach.jpg')


def trust_strip():
    return grp(grp(ul(['30+ years serving Orange County', 'Free private consultation', 'Client rating: pending verification'], 'dx-strip__list'), '', align='wide'),
               'dx-strip', tag='section', layout=CONSTRAINED)


def sticky_bar():
    left = grp(p('A private next step, whenever you’re ready.', 'dx-stickybar__title') + p('Free consultation · About one hour · Studio or Zoom', 'dx-stickybar__meta'), 'dx-stickybar__text')
    return grp(grp(left + p('<a href="tel:+19493052661">(949) 305-2661</a>', 'dx-stickybar__phone') + buttons(button('Book a Consultation', BOOK, 'gold')), 'dx-stickybar__row', align='wide'),
               'dx-stickybar', tag='section', layout=CONSTRAINED)


def overview():
    left = grp(eyebrow('SMP / A different approach') + h(2, 'A considered option for a closer-cropped look.') +
               p('Scalp micropigmentation is a cosmetic technique that uses pigment on the scalp to create the appearance of hair density. A private consultation is a place to discuss suitability, goals and limitations.') +
               eyebrow('Who it’s for') +
               ul(['People exploring the appearance of hair density', 'Those considering a closely cropped style',
                   'People looking for a cosmetic option', 'Anyone wanting to discuss suitability privately'], 'dx-checks'), 'dx-stack')
    right = image('sample-man-bench.jpg', 'A man sitting on a bench by the coast', 'dx-split__img')
    return band('canvas', grp(left + right, 'dx-grid dx-grid--2 dx-split') +
                p('Editorial lifestyle image shown for layout. Service-specific photography is subject to approval.', 'dx-note'))


def made_personal():
    cards = ''.join(grp(p(n, 'dx-feature__num') + h(3, t) + p(d), 'dx-feature') for n, t, d in [
        ('01', 'A considered design', 'Discuss hairline shape and your preferences.'),
        ('02', 'A personal discussion', 'Understand the process and its limitations.'),
        ('03', 'Private appointments', 'A discreet space to talk through your options.'),
        ('04', 'Clear aftercare', 'Discuss aftercare and future maintenance.')])
    return band('soft', eyebrow('Made personal') + h(2, 'Care shaped around you.') + grp(cards, 'dx-grid dx-grid--4'))


def four_steps():
    steps = ''.join(grp(eyebrow(f'{n} / {lab}') + h(3, t) + p(d), 'dx-step dx-stack') for n, lab, t, d in [
        ('01', 'Consultation', 'Start with a conversation', 'A free, private consultation. About one hour in studio or by Zoom.'),
        ('02', 'Design &amp; match', 'Explore a personal approach', 'Discuss the proposed look, suitability and limitations.'),
        ('03', 'Treatment plan', 'Agree on next steps', 'Review the proposed sessions and aftercare before proceeding.'),
        ('04', 'Ongoing care', 'Know how to care for it', 'Ask about a care routine and any follow-up that may be needed.')])
    return band('white', eyebrow('Four steps / Unhurried care') + h(2, 'A clear path, with you at the center.') + grp(steps, 'dx-grid dx-grid--4'))


def what_to_expect():
    items = ''.join(grp(h(3, t) + p(d), 'dx-expect__item dx-stack') for t, d in [
        ('Appointment length', 'Typical session: [confirm duration]'),
        ('Maintenance cadence', 'Typical follow-up: [confirm interval]'),
        ('Longevity', 'Typical longevity: [confirm range]'),
        ('Everyday care', 'Personal care plan: [confirm guidance]')])
    return band('navy', eyebrow('What to expect') + h(2, 'No surprises. Room for your questions.') +
                p('Your specialist will explain what is typical for the option you choose. Details vary by person; confirm the plan before you proceed.') +
                grp(items, 'dx-grid dx-grid--4') +
                p('Editable planning fields—not published promises. Confirm service details with Dermatex.', 'dx-note'))


def results():
    def card(n):
        return grp(compare('Approved before photo pending', 'Approved after photo pending') +
                   h(3, f'SMP / example {n}') + p('First name · Treatment details and timeline to confirm'), 'dx-card dx-resultcard')
    return band('canvas', eyebrow('Real people / Approved photos') + h(2, 'Explore the detail. Ask what’s right for you.') +
                grp(card(1) + card(2), 'dx-grid dx-grid--2') +
                p('Approved client comparisons pending. Photos shared with client permission. Individual experiences vary.', 'dx-note') +
                p('<a href="/#stories">See full gallery →</a>'))


def pricing():
    left = grp(h(3, 'Your investment') + p('Starting at $ [amount]', 'dx-price') + p('$ [amount] / per month') +
               p('Editable pricing fields. Confirm the appropriate structure and amounts with Dermatex before publishing.', 'dx-note'),
               'dx-pricecard dx-stack')
    right = grp(h(3, 'Understand the whole picture.') +
                p('Discuss the initial appointment, any follow-up and ongoing care. We’ll explain the available choices so you can make an informed decision.') +
                buttons(button('Book a consultation for a personalized quote', BOOK, 'gold')), 'dx-stack')
    return band('soft', eyebrow('Investment &amp; maintenance') + h(2, 'A personal plan. A clear conversation.') +
                grp(left + right, 'dx-grid dx-grid--2 dx-pricing'))


def reviews():
    cards = ''.join(grp(p('[Approved client review to be supplied]', 'dx-review__quote') + p('<strong>[Approved first name]</strong>') +
                        p('[Source and date to confirm]', 'dx-note'), 'dx-review') for _ in range(3))
    return band('canvas', eyebrow('Client voices') + h(2, 'A more personal kind of care.') +
                p('Approved reviews will appear here. No ratings or outcomes are claimed in this template.', 'dx-note') +
                grp(cards, 'dx-grid dx-grid--3'))


def service_faq():
    return band('white', eyebrow('Good questions') + h(2, 'A little clarity, before we meet.') +
                faq([('Is SMP right for me?', 'A private consultation is the place to discuss suitability.'),
                     ('What happens during the consultation?', 'A free, private conversation of about one hour, in our Laguna Hills studio or by Zoom.'),
                     ('How many appointments will I need?', '[Answer to be supplied by Dermatex]'),
                     ('What aftercare should I expect?', '[Answer to be supplied by Dermatex]'),
                     ('How do I get a personalized quote?', 'Book a consultation. We’ll explain the available choices and the investment for your plan.')]))


def related():
    return band('soft', eyebrow('Other ways / Personal choices') + h(2, 'Keep your options open.') +
                service_cards([('sample-man-beach.jpg', 'Men’s Hair Replacement', '/#men', 'A man walking on a beach'),
                               ('sample-woman-garden.jpg', 'Virtuesse for Women', '/#women', 'A smiling woman outdoors'),
                               ('sample-hair-swatches.jpg', 'DermaStrand Hair Additions', '/#women', 'Hair color swatches beside a comb')]))


# ---------- empty bands ----------
def empty_band(style):
    return band(style, eyebrow('Eyebrow label') + h(2, 'Section heading') + p('Add your content here. Change the band color from Styles in the block sidebar.') +
                buttons(button('Book a Consultation', BOOK, 'gold')))


# ---------- output ----------
def header(slug, title, cats, kw, page_start=False, desc=''):
    lines = ['<?php', '/**', f' * Title: {title}', f' * Slug: dermatex/{slug}', f' * Categories: {cats}', f' * Keywords: {kw}']
    if desc: lines.append(f' * Description: {desc}')
    if page_start:
        lines += [' * Block Types: core/post-content', ' * Post Types: page', ' * Viewport Width: 1440']
    lines += [' * Inserter: true', ' */', '?>', '']
    return '\n'.join(lines)


def write(slug, title, cats, kw, body, page_start=False, desc=''):
    with open(f'{OUT}/{slug}.php', 'w') as f:
        f.write(header(slug, title, cats, kw, page_start, desc) + body)


# remove previously generated subpage files
for f in glob.glob(f'{OUT}/subpage-*.php') + glob.glob(f'{OUT}/sec-*.php'):
    os.remove(f)

PAGES = 'dermatex-pages'
SECS = 'dermatex-sections'

write('subpage-info', 'Subpage: Informational', PAGES, 'subpage, informational, article, guide, text',
      info_hero() + info_intro() + key_takeaways() + info_body() + compare_table() + info_faq() + keep_exploring() + contact_band('canvas'),
      True, 'Text-heavy page: on-page contents, key takeaways, comparison table, FAQ and related guides.')
write('subpage-media', 'Subpage: Media & stories', PAGES, 'subpage, media, gallery, video, stories, before after',
      media_hero() + media_intro() + gallery() + video_band() + story_split() + contact_band('soft', 'See what’s possible for you'),
      True, 'Filterable photo gallery, YouTube video band and a featured story.')
write('subpage-service', 'Subpage: Service', PAGES, 'subpage, service, smp, hair system, wig',
      service_hero() + trust_strip() + sticky_bar() + overview() + made_personal() + four_steps() + what_to_expect() + results() +
      pricing() + reviews() + service_faq() + related() + contact_band('canvas'),
      True, 'One page per service: overview, benefits, steps, what to expect, results, pricing, reviews, FAQ and related services.')

sections = [
    ('sec-hero', 'Subpage hero (banner image)', 'hero, banner, subpage', hero('info', 'Eyebrow label', 'Page title', 'One or two sentences introducing the page.', 'sample-studio-consult.jpg')),
    ('sec-trust-strip', 'Trust strip', 'trust, strip, claims', trust_strip()),
    ('sec-sticky-bar', 'Sticky booking bar (desktop)', 'sticky, cta, booking', sticky_bar()),
    ('sec-intro-toc', 'Intro with “On this page” contents', 'toc, contents, intro', info_intro()),
    ('sec-key-takeaways', 'Key takeaways', 'summary, takeaways', key_takeaways()),
    ('sec-compare-table', 'Comparison table', 'table, compare', compare_table()),
    ('sec-split', 'Text + image with checklist', 'split, overview, image', overview()),
    ('sec-feature-cards', 'Feature cards (4)', 'cards, features, benefits', made_personal()),
    ('sec-steps', 'Four steps', 'steps, process', four_steps()),
    ('sec-expect', 'What to expect (navy)', 'expect, details', what_to_expect()),
    ('sec-before-after', 'Before / after pair', 'before after, results', results()),
    ('sec-gallery', 'Filterable gallery', 'gallery, filter, photos', gallery()),
    ('sec-video', 'Video band (navy)', 'video, youtube', video_band()),
    ('sec-story', 'Featured story', 'story, quote', story_split()),
    ('sec-pricing', 'Investment and maintenance', 'pricing, cost', pricing()),
    ('sec-reviews', 'Client voices (3 reviews)', 'reviews, testimonials', reviews()),
    ('sec-faq', 'FAQ (5 questions)', 'faq, questions', service_faq()),
    ('sec-related', 'Related service cards', 'related, services, cards', related()),
    ('sec-guides', 'Related guides (3 article cards)', 'articles, guides, cards', keep_exploring()),
    ('sec-contact', 'Consultation band', 'cta, contact, address, hours', contact_band('canvas')),
    ('sec-band-canvas', 'Empty full-width band: Canvas', 'band, background', empty_band('canvas')),
    ('sec-band-white', 'Empty full-width band: White', 'band, background', empty_band('white')),
    ('sec-band-soft', 'Empty full-width band: Soft cream', 'band, background', empty_band('soft')),
    ('sec-band-navy', 'Empty full-width band: Navy', 'band, background', empty_band('navy')),
    ('sec-band-gold', 'Empty full-width band: Gold', 'band, background', empty_band('gold')),
]
for slug, title, kw, body in sections:
    write(slug, 'Section: ' + title, SECS, kw, body)
print('wrote', 3 + len(sections), 'patterns')
