🤖 LLM Instructions & Coding Rules
Agriculture Equipment Rental System (AERS)

This document defines strict rules and preferences that any Large Language Model (LLM) or AI coding assistant must follow while contributing to this project.

These rules exist to ensure:

Code quality

Maintainability

Predictability

Safety in development, testing, and production environments

1️⃣ Coding Pattern Preferences
1.1 General Coding Philosophy

Always prefer simple, readable, and maintainable solutions

Avoid over-engineering

Clarity is more important than cleverness

1.2 Code Reusability & Duplication

Avoid duplication of code whenever possible

Before writing new logic:

Search the codebase for similar functionality

Reuse or refactor existing code if appropriate

Do not create multiple implementations for the same behavior

1.3 Environment Awareness

Always consider three environments:

development (dev)

testing (test)

production (prod)

Code must behave safely and predictably in all environments

Environment-specific logic must be clearly separated and documented

1.4 Scope of Changes

Only make changes that are:

Explicitly requested, or

Clearly understood and directly related to the requested change

Do NOT refactor or improve unrelated code “just because”

1.5 Bug Fixing Rules

When fixing a bug:

First, try to fix it using the existing patterns and architecture

Do NOT introduce a new pattern or technology unless absolutely necessary

If a new approach is introduced:

The old implementation must be fully removed

No duplicate or parallel logic is allowed

1.6 Codebase Cleanliness

Keep the codebase:

Clean

Well-organized

Easy to navigate

Follow consistent naming conventions

Group related logic together

1.7 File Size & Structure

Avoid files exceeding 200–300 lines of code

If a file grows beyond this:

Refactor into smaller, well-defined modules

Each file should have a single clear responsibility

1.8 Scripts & One-Off Code

Avoid writing scripts inside the main codebase if possible

Especially avoid scripts that are:

Intended to be run only once

Not reusable

If unavoidable, isolate them clearly and document their purpose

1.9 Data Mocking Rules

Mock data is allowed ONLY for testing

Never mock data in:

Development environment

Production environment

Never introduce:

Fake data

Stub logic

Temporary placeholders
into dev or prod code paths

1.10 Environment Files Safety

Never overwrite or modify the .env file

Always ask for confirmation before:

Editing

Replacing

Regenerating environment variables

2️⃣ Project Tech Stack Awareness

The LLM must strictly follow the approved project stack:

Frontend

HTML5

CSS3

Bootstrap 5

JavaScript

Backend

Core PHP

Database

MySQL

Server & Tools

Apache (XAMPP)

phpMyAdmin

Git (version control)

❌ Do NOT introduce:

New frameworks

New languages

New databases

New authentication systems
unless explicitly instructed

3️⃣ Coding Workflow Preferences
3.1 Task-Focused Development

Focus only on the code areas relevant to the given task

Do not modify:

Unrelated files

Unrelated logic

Working features

3.2 Change Isolation

Each change should be:

Small

Understandable

Isolated

Avoid large, sweeping changes unless explicitly requested

3.3 Testing Expectations

Write thorough tests for all major functionality

Tests must:

Validate expected behavior

Cover edge cases

Fail clearly when something breaks

3.4 Architecture Stability

Do not make major architectural or pattern changes once a feature:

Is implemented

Is working correctly

Architectural changes are allowed only when explicitly instructed

3.5 Impact Awareness

Always consider:

Which other modules might be affected

Whether changes could break existing flows

Think defensively before modifying shared logic

4️⃣ Version Control Rules

Use Git consistently

Make small, meaningful commits

Each commit should:

Represent a single logical change

Have a clear commit message

Do not mix unrelated changes in one commit

5️⃣ Documentation Discipline

Every major change must be:

Clearly documented

Added to the /docs directory if applicable

Keep documentation:

Up to date

Simple

Aligned with actual implementation